<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NormsRequest;
use App\Model\GoodsType;
use App\Model\Norms;
use App\Model\NormsGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NormsController extends Controller
{
    //规格属性列表  搜索分页
    public function index(Norms $norms,NormsGroup $normsGroup,GoodsType $goodsType,Request $request){
        //接收传过来的 搜索 的值
        $info['f_norms_group_id']=$request->input('f_norms_group_id')?[$request->input('f_norms_group_id')]:0;//分组
        $info['name']=$request->input('name')?$request->input('name'):"";  //属性
        $info['f_goods_type_id']=$request->input('f_goods_type_id')?[$request->input('f_goods_type_id')]:0;//商品分类

        //判断规格分组 为空
        if (!$info['f_norms_group_id'])
        {
            $ids = $normsGroup::select(DB::raw("GROUP_CONCAT(id) as ids"))->first()->toArray();
            $info['f_norms_group_id'] = explode(',',$ids['ids']);
        }
        //判断属性 为空
        if (!$info['f_goods_type_id'])
        {
            $id = $goodsType::select(DB::raw("GROUP_CONCAT(id) as ids"))->first()->toArray();
            $info['f_goods_type_id'] = explode(',',$id['ids']);
        }

        //从数据库查询  with关联模型
        $normsGroupInfo = $normsGroup::select('id','name')->get()->toArray();  //所有规格分组
        $normsInfos=$norms::with("goodsType","normsGroup")->where('name','like',"%{$info['name']}%")->whereIn('f_norms_group_id',$info['f_norms_group_id'])->whereIn('f_goods_type_id',$info['f_goods_type_id'])->paginate(15);
        $normsInfo=$normsInfos->toArray();
        $goodsTypeInfo = $goodsType::get()->toArray();    //所有商品分类
        $goodsTypeInfo = make_tree($goodsTypeInfo);

        //判断规格个数
        if (count($info['f_norms_group_id'])==1)
        {
            $info['f_norms_group_id']=$info['f_norms_group_id'][0];
        }else
            {
                $info['f_norms_group_id']=0;
            }
        //判断属性个数
        if (count($info['f_goods_type_id'])==1)
        {
            $info['f_goods_type_id']=$info['f_goods_type_id'][0];
        }else
        {
            $info['f_goods_type_id']=0;
        }
        return view('admin.norms.index',compact('normsInfo','normsInfos','info','normsGroupInfo','goodsTypeInfo'));
    }

    //添加规格属性
    public function create(GoodsType $goodsType,NormsGroup $normsGroup){
        $goodsTypeInfo=$goodsType::get()->toArray();
        $goodsTypeInfo = make_tree($goodsTypeInfo);
        $normsgroupInfo = $normsGroup::select('id','name')->get()->toArray();
        return view('admin.norms.create',compact('goodsTypeInfo','normsgroupInfo'));
    }
    //处理添加
    public function add(Request $request,Norms $norms){
        $data = $request->except('_token');
        if(!$data['name'])
        {
            unset($data['name']);
        }
        if ($norms->create($data)){
            return redirect()->route('norms.list')->with(['msg'=>'添加成功']);
        }else{
            return back()->with(['msg'=>'添加失败']);
        }
    }
    //修改规格属性
    public function edit(GoodsType $goodsType,NormsGroup $normsGroup,Norms $norms,$id){
        $goodsTypeInfo=$goodsType->get()->toArray();    //商品分类
        $normsGroupInfo=$normsGroup->get()->toArray();  //分组
        $normsInfo=$norms::with('goodsType')->find($id)->toArray();        //属性
        $goodsTypeInfo = make_tree($goodsTypeInfo);
        return view('admin.norms.edit',compact('goodsTypeInfo',"normsGroupInfo","normsInfo"));
    }
    //处理修改
    public function update(Norms $norms,Request $request,$id){
        $data = $request->except('_token');
        $data['name']=$data['name']?$data['name']:"";
        if($norms::find($id)->update($data)){
            return redirect()->route("norms.list")->with(['msg'=>'编辑成功']);
        }else{
            return back()->with(['msg'=>'编辑失败']);
        }
    }
    //删除规格属性
    public function delete(Norms $norms,$id){
        if ($norms::find($id)->delete()){
            return json('200','删除成功');
        }else{
            return back()->with('删除失败');
        }
    }
}
