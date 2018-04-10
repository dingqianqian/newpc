<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GoodsRequest;
use App\Model\Goods;
use App\Model\GoodsDetailsImg;
use App\Model\GoodsImg;
use App\Model\GoodsStatus;
use App\Model\GoodsType;
use App\Model\NormsCombo;
use App\Model\NormsGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Xujif\UcloudUfileSdk\UfileSdk;

class GoodsController extends Controller
{
    //商品列表
    public function index(Goods $goods,NormsGroup $normsGroup,Request $request,GoodsType $goodsType,GoodsStatus $goodsStatus)
    {
        //获取商品分类
        $goodsTypeInfo=$goodsType::whereNotIn("parent_id",[0,56])->get()->toArray();
        //获取所有商品状态
        $goodsStatusInfo=$goodsStatus::all()->toArray();
        //获取商品分类
        $info['name']=$request->input("name")?$request->input("name"):"";
        $info['id']=$request->input("id")?$request->input("id"):"";
        $info['category']=$request->input("category")?$request->input("category"):0;
        $info['status']=$request->input("status")?[$request->input("status")]:[1,2,3,4,5];
        //获取商品列表
        if ($info['id'])
        {
            if ($info['category'])
            {
                $goodsInfos=$goods::with("goodsStatus","goodsType")->where([["name","like","%{$info['name']}%"],["id",$info['id']],["f_goods_type_id",$info['category']]])->whereIn("f_goods_status_id",$info['status'])->paginate(15);
            }else
                {
                    $goodsInfos=$goods::with("goodsStatus","goodsType")->where([["name","like","%{$info['name']}%"],["id",$info['id']]])->whereIn("f_goods_status_id",$info['status'])->paginate(15);
                }
        }else
            {
                if ($info['category'])
                {
                    $goodsInfos=$goods::with("goodsStatus","goodsType")->where([["name","like","%{$info['name']}%"],["f_goods_type_id",$info['category']]])->whereIn("f_goods_status_id",$info['status'])->paginate(15);
                }else
                    {
                        $goodsInfos=$goods::with("goodsStatus","goodsType")->where("name","like","%{$info['name']}%")->whereIn("f_goods_status_id",$info['status'])->paginate(15);
                    }
            }

        $goodsInfo=$goodsInfos->toArray();
        foreach ($goodsInfo['data'] as $k =>$v)
        {
            $normsGroupId=explode(",",$v['f_norms_group_id']);
            $normsGroupInfo=$normsGroup->whereIn("id",$normsGroupId)->get()->toArray();
            $goodsInfo['data'][$k]["norms_group"]=$normsGroupInfo;
        }
        if (count($info['status'])==1)
        {
            $info['status']=$info['status'][0];
        }else
            {
                $info['status']=0;
            }
        return view("admin.goods.index",compact("goodsInfo","goodsInfos","info","goodsTypeInfo","goodsStatusInfo"));
    }
    //添加商品
    public function create(NormsGroup $normsGroup,GoodsType $goodsType,GoodsStatus $goodsStatus,Request $request)
    {
        //获取商品分类
        $goodsTypeInfo=$goodsType->get()->toArray();
        $goodsTypeInfo=make_tree($goodsTypeInfo);
        foreach ($goodsTypeInfo as $k=>$v)
        {
            if (!isset($v['child']))
            {
                unset($goodsTypeInfo[$k]);
            }
        }
        sort($goodsTypeInfo);
        //获取所有商品状态
        $goodsStatusInfo=$goodsStatus::all()->toArray();
        //获取规格分组
        $normsGroupInfo=$normsGroup::all()->toArray();
        //dd($goodsTypeInfo);
        return view("admin.goods.create",compact("goodsTypeInfo","normsGroupInfo","goodsStatusInfo"));
    }
    //处理添加
    public function add(GoodsRequest $request,Goods $goods,GoodsImg $goodsImg,GoodsDetailsImg $goodsDetailsImg)
    {
        //1.添加商品
        $data=$request->only(["name","open_id","send_time","unit","explain","min_sale","show_price","show_sale_price","f_goods_status_id","f_goods_type_id"]);
        $data['create_time']=time();
        $normsGroup=$request->input("norms_group");
        asort($normsGroup);
        $data['f_norms_group_id']=implode(",",$normsGroup);
        $goodsInfo=$goods->create($data);
        //2.保存商品详情图
        $ufile=new UfileSdk(env("KOCKET"),"WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==","2ee9865d56c51fe23890983e69811e3139c73029");
        $detailsName=make_rand_str().".jpg";
        $path=Storage::putFileAs('public/goodsDetailsImg',$request->file("detailsImg"),$detailsName);
        $ufile->putFile($detailsName,"./storage/goodsDetailsImg/$detailsName");
        $goodsDetailsImgData['f_goods_id']=$goodsInfo->id;
        $goodsDetailsImgData['name']=$detailsName;
        $goodsDetailsImg->create($goodsDetailsImgData);
        //3.保存商品主图
        if (!file_exists("images/goodsImg"))
        {
            mkdir("images/goodsImg",0777,true);
            chmod("images/goodsImg",0777);
        }
        if (!file_exists("images/goodsImgSmall"))
        {
            mkdir("images/goodsImgSmall",0777,true);
            chmod("images/goodsImgSmall",0777);
        }
        $goodsImgName=make_rand_str().".jpg";
        $goodsImgName=Image::make($request->file("masterImg"))->encode('jpg')->save("images/goodsImg/$goodsImgName")->basename;
        $goodsImgNameSmall=Image::make($request->file("masterImg"))->resize(350,350)->encode('jpg')->save("images/goodsImgSmall/s_$goodsImgName")->basename;
        $ufile->putFile($goodsImgName,"images/goodsImg/$goodsImgName");
        $ufile->putFile($goodsImgNameSmall,"images/goodsImgSmall/$goodsImgNameSmall");
        $goodsImgData['f_goods_id']=$goodsInfo->id;
        $goodsImgData['name']=$goodsImgName;
        $goodsImgData['thumb']=$goodsImgNameSmall;
        $goodsImgData['is_lead']="T";
        $goodsImgInfo=$goodsImg->create($goodsImgData);
        //循环添加商品其他图片
        if ($request->input("goodsImg"))
        {
            foreach ($request->input("goodsImg") as $k=>$v)
            {
                $ufile->putFile($v,"images/goodsImg/$v");
                $ufile->putFile("s_$v","images/goodsImgSmall/s_$v");
                $goodsImgData['f_goods_id']=$goodsInfo->id;
                $goodsImgData['name']=$v;
                $goodsImgData['thumb']="s_".$v;
                $goodsImgData['is_lead']="F";
                $goodsImgInfo=$goodsImg->create($goodsImgData);
            }
        }
        return redirect()->route("goods.list");
    }
    //上传图片
    public function upload(Request $request)
    {
        if (!file_exists("images/goodsImg"))
        {
            mkdir("images/goodsImg",0777,true);
            chmod("images/goodsImg",0777);

        }
        if (!file_exists("images/goodsImgSmall"))
        {
            mkdir("images/goodsImgSmall",0777,true);
            chmod("images/goodsImgSmall",0777);

        }
        $goodsImgName=make_rand_str().".jpg";
        $goodsImgName=Image::make($request->file("goodsImg"))->encode('jpg')->save("images/goodsImg/$goodsImgName")->basename;
        $goodsImgNameSmall=Image::make($request->file("goodsImg"))->resize(350,350)->encode('jpg')->save("images/goodsImgSmall/s_$goodsImgName")->basename;
        return $goodsImgName;
    }
    //删除商品
    public function delete(Goods $goods,GoodsImg $goodsImg,GoodsDetailsImg $goodsDetailsImg,NormsCombo $normsCombo,$id)
    {
        //删除商品
        $goods::destroy($id);
        $normsCombo->where("f_goods_id",$id)->delete();
        return json(200,"删除成功");
    }
    //编辑商品
    public function edit(NormsCombo $normsCombo,Goods $goods,NormsGroup $normsGroup,GoodsType $goodsType,GoodsStatus $goodsStatus,Request $request,$id)
    {
        //获取商品分类
        $goodsTypeInfo=$goodsType->get()->toArray();
        $goodsTypeInfo=make_tree($goodsTypeInfo);
        foreach ($goodsTypeInfo as $k=>$v)
        {
            if (!isset($v['child']))
            {
                unset($goodsTypeInfo[$k]);
            }
        }
        sort($goodsTypeInfo);
        //获取所有商品状态
        $goodsStatusInfo=$goodsStatus::all()->toArray();
        //获取规格分组
        $normsGroupInfo=$normsGroup::all()->toArray();

        //获取商品的基本信息和详情图信息和组图信息
        $goodsInfo=$goods::with('goodsDetailsImg',"goodsImg","goodsType")->where("id",$id)->first()->toArray();
        //dd($goodsInfo);
        if ($goodsInfo['goods_details_img'])
        {
                $goodsInfo['goods_details_img']['url']="http://".$normsCombo->setCache($goodsInfo['goods_details_img']['name']);
        }
        if ($goodsInfo['goods_img'])
        {
            foreach ($goodsInfo['goods_img'] as $k=>$v)
            {
                $goodsInfo['goods_img'][$k]['url']="http://".$normsCombo->setCache($v['name']);
                $goodsInfo['goods_img'][$k]['thumb_url']="http://".$normsCombo->setCache($v['thumb']);
            }
        }
        $goodsInfo['f_norms_group_id']=explode(',',$goodsInfo['f_norms_group_id']);
        return view("admin.goods.edit",compact("goodsTypeInfo","normsGroupInfo","goodsStatusInfo","goodsInfo"));
    }
    //编辑商品
    public function update(GoodsImg $goodsImg,GoodsDetailsImg $goodsDetailsImg,Goods $goods,GoodsRequest $request,$id)
    {
        //1.编辑商品
        $data=$request->only(["name","open_id","send_time","unit","explain","min_sale","show_price","show_sale_price","f_goods_status_id","f_goods_type_id"]);
        $data['update_time']=time();
        $normsGroup=$request->input("norms_group");
        asort($normsGroup);
        $data['f_norms_group_id']=implode(",",$normsGroup);
        $goodsInfo=$goods::find($id)->update($data);
        //2.保存商品详情图
        $ufile=new UfileSdk(env("KOCKET"),"WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==","2ee9865d56c51fe23890983e69811e3139c73029");
        if ($request->file("detailsImg"))
        {
            if (!file_exists("images/goodsDetailsImg"))
            {
                mkdir("images/goodsDetailsImg",0777,true);
                chmod("images/goodsDetailsImg",0777);
            }
            $detailsName=make_rand_str().".jpg";
            $path=Storage::putFileAs('public/goodsDetailsImg',$request->file("detailsImg"),$detailsName);
            $ufile->putFile($detailsName,"./storage/goodsDetailsImg/$detailsName");
            $goodsDetailsImgData['f_goods_id']=$id;
            $goodsDetailsImgData['name']=$detailsName;
            $goodsDetailsImg->create($goodsDetailsImgData);
        }

        //3.保存商品主图
        if ($request->file("masterImg"))
        {
            //更新所有的图片为F
            $goodsImg::where("f_goods_id",$id)->update(["is_lead"=>"F"]);
            if (!file_exists("images/goodsImg"))
            {
                mkdir("images/goodsImg",0777,true);
                chmod("images/goodsImg",0777);

            }
            if (!file_exists("images/goodsImgSmall"))
            {
                mkdir("images/goodsImgSmall",0777,true);
                chmod("images/goodsImgSmall",0777);

            }
            $goodsImgName=make_rand_str().".jpg";
            $goodsImgName=Image::make($request->file("masterImg"))->encode('jpg')->save("images/goodsImg/$goodsImgName")->basename;
            $goodsImgNameSmall=Image::make($request->file("masterImg"))->resize(350,350)->encode('jpg')->save("images/goodsImgSmall/s_$goodsImgName")->basename;
            $ufile->putFile($goodsImgName,"images/goodsImg/$goodsImgName");
            $ufile->putFile($goodsImgNameSmall,"images/goodsImgSmall/$goodsImgNameSmall");
            $goodsImgData['f_goods_id']=$id;
            $goodsImgData['name']=$goodsImgName;
            $goodsImgData['thumb']=$goodsImgNameSmall;
            $goodsImgData['is_lead']="T";
            $goodsImgInfo=$goodsImg->create($goodsImgData);
        }
        //循环添加商品其他图片
        if ($request->input("goodsImg"))
        {
            foreach ($request->input("goodsImg") as $k=>$v)
            {
                $ufile->putFile($v,"images/goodsImg/$v");
                $ufile->putFile("s_$v","images/goodsImgSmall/s_$v");
                $goodsImgData['f_goods_id']=$id;
                $goodsImgData['name']=$v;
                $goodsImgData['thumb']="s_".$v;
                $goodsImgData['is_lead']="F";
                $goodsImgInfo=$goodsImg->create($goodsImgData);
            }
        }
        return redirect()->route("goods.list");
    }
    //删除商品规格图片
    public function delImg(GoodsImg $goodsImg,$id)
    {
        $goodsImg::destroy($id);
        return json(200,"删除成功");
    }
    //删除商品详情图
    public function delDetailsImg(GoodsDetailsImg $goodsDetailsImg,$id)
    {
        $goodsDetailsImg::destroy($id);
        return json(200,"删除成功");
    }
    //商品上下架
    public function status(Goods $goods,$id)
    {
        $goodsInfo=$goods::find($id);
        if ($goodsInfo->f_goods_status_id==1)
        {
            $goodsInfo->f_goods_status_id=5;
            $goodsInfo->save();
            return json(200,"下架成功");
        }
        if ($goodsInfo->f_goods_status_id==5)
        {
            $goodsInfo->f_goods_status_id=1;
            $goodsInfo->save();
            return json(200,"上架成功");
        }
        return json(200,"商品状态不可更改");
    }

    //商品列表导出
    public function export(Goods $goods,NormsGroup $normsGroup,Request $request,GoodsType $goodsType,GoodsStatus $goodsStatus)
    {
        //获取商品分类
        $goodsTypeInfo=$goodsType::whereNotIn("parent_id",[0,56])->get()->toArray();
        //获取所有商品状态
        $goodsStatusInfo=$goodsStatus::all()->toArray();
        //获取商品分类
        $info['name']=$request->input("name")?$request->input("name"):"";
        $info['id']=$request->input("id")?$request->input("id"):"";
        $info['category']=$request->input("category")?$request->input("category"):0;
        $info['status']=$request->input("status")?[$request->input("status")]:[1,2,3,4,5];
        //获取商品列表
        if ($info['id'])
        {
            if ($info['category'])
            {
                $goodsInfos=$goods::with("goodsStatus","goodsType")->where([["name","like","%{$info['name']}%"],["id",$info['id']],["f_goods_type_id",$info['category']]])->whereIn("f_goods_status_id",$info['status'])->get();
            }else
            {
                $goodsInfos=$goods::with("goodsStatus","goodsType")->where([["name","like","%{$info['name']}%"],["id",$info['id']]])->whereIn("f_goods_status_id",$info['status'])->get();
            }
        }else
        {
            if ($info['category'])
            {
                $goodsInfos=$goods::with("goodsStatus","goodsType")->where([["name","like","%{$info['name']}%"],["f_goods_type_id",$info['category']]])->whereIn("f_goods_status_id",$info['status'])->get();
            }else
            {
                $goodsInfos=$goods::with("goodsStatus","goodsType")->where("name","like","%{$info['name']}%")->whereIn("f_goods_status_id",$info['status'])->get();
            }
        }

        $goodsInfo=$goodsInfos->toArray();
        foreach ($goodsInfo as $k =>$v)
        {
            $normsGroupId=explode(",",$v['f_norms_group_id']);
            $normsGroupInfo=$normsGroup->whereIn("id",$normsGroupId)->get()->toArray();
            $goodsInfo[$k]["norms_group"]=$normsGroupInfo;
        }
        if (count($info['status'])==1)
        {
            $info['status']=$info['status'][0];
        }else
        {
            $info['status']=0;
        }
//        dd($goodsInfo[0]);
        //整成一维数组
        $data[]=[
            '编号',
            '商品名称',
            '所属分类',
            '录入时间',
            '商品规格组合',
            '状态',
            '商品价格',
            '11121(价格)',
        ];
        foreach($goodsInfo as $k=>$v){
            $temp['id'] = $v['id'];
            $temp['open_id'] = $v['open_id'];
            $temp['goods_type'] = $v['goods_type']['name'];
            $temp['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $temp['norms_group']="";
            foreach ($v['norms_group'] as $kk=>$vv){
                $temp['norms_group'] .= $vv['name']."|";
            }
            $temp['norms_group']=trim($temp['norms_group'],"|");
            $temp['status'] = $v['goods_status']['name'];
            $temp['show_price'] = $v['show_price'];
            $temp['show_sale_price'] = $v['show_sale_price'];
            $data[] = $temp;
        }
        Excel::create('goods',function($excel) use ($data){
            $excel->sheet('goods', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');

    }
}
