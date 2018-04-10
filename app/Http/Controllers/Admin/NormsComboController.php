<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NormsComboRequest;
use App\Jobs\NormsComboArea;
use App\Jobs\NormsComboEdit;
use App\Jobs\NormsComboPrice;
use App\Model\Area;
use App\Model\Goods;
use App\Model\GoodsDetailsImg;
use App\Model\GoodsImg;
use App\Model\GoodsType;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\NormsGroup;
use App\Model\RelationNormsComboGoodsImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class NormsComboController extends Controller
{
    //sku列表
    public function index(NormsCombo $normsCombo, Norms $norms, GoodsType $goodsType, Request $request,Goods $goods,Area $area)
    {
        //搜索
        $info['name'] = $request->input("name") ? $request->input("name") : "";
        $info['type'] = $request->input("type") ? $request->input("type") : 0;
        $info['category'] = $request->input("category") ? $request->input("category") : 0;
        $info['f_area_id']=$request->input("f_area_id")?$request->input("f_area_id"):1;
        if (session("employeeInfo")['f_area_id']!=1)
        {
            $info['f_area_id']=session("employeeInfo")['f_area_id'];
        }
        if (!$info['type'])
        {
            $types=$goodsType::all()->toArray();
            $type=[];
            foreach ($types as $k=>$v)
            {
                $type[]=$v['id'];
            }
        }else
            {
                if (!$info['category'])
                {
                    $types=$goodsType->where("parent_id",$info['type'])->get()->toArray();
                    $type=[];
                    foreach ($types as $k=>$v)
                    {
                        $type[]=$v['id'];
                    }
                }else
                    {
                        $type=[$info['category']];
                    }
            }
        //获取商品ID
        $goodsIds=$goods::where("open_id","like","%{$info['name']}%")->whereIn("f_goods_type_id",$type)->get()->toArray();
        $goodsId=[];
        foreach ($goodsIds as $k=>$v)
        {
         $goodsId[]=$v['id'];
        }
        $normsComboInfos = $normsCombo::with("goods", "goodsImg","area")->where("f_area_id",$info['f_area_id'])->whereIn("f_goods_id",$goodsId)->paginate(15);
        $count=$normsCombo->count();
        $normsComboInfo = $normsComboInfos->toArray();
        foreach ($normsComboInfo['data'] as $k => $v) {
            $normsComboInfo['data'][$k]['norms'] = $norms->whereIn("id", explode(",", $v['f_norms_id']))->get()->toArray();
            $normsComboInfo['data'][$k]['thumb_url'] = "http://" . $normsCombo->setCache($v['goods_img']['name']);
            $goodsTypeInfo = $goodsType::find($v['goods']['f_goods_type_id']);
//            dd($normsComboInfo);
            if ($goodsTypeInfo) {
                $normsComboInfo['data'][$k]['category'] = $goodsTypeInfo->name;
                $normsComboInfo['data'][$k]['type'] = $goodsType::find($goodsTypeInfo->parent_id)->name;
            } else {
                $normsComboInfo['data'][$k]['category'] = "未知";
                $normsComboInfo['data'][$k]['type'] = "未知";
            }
        };
        $goodsTypeInfo = make_tree($goodsType::all()->toArray());
        $ids = Area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->get()->toArray();
        foreach ($ids as $k=>$v){
            $id = array_unique(explode(",",$v["ids"]));
        }
        if (session("employeeInfo")['f_area_id']!=1)
        {
            $areaInfo = Area::select("id","name")->where("id",session("employeeInfo")['f_area_id'])->orWhere("parent_id",session("employeeInfo")['f_area_id'])->get()->toArray();
        }else
            {
                $areaInfo = Area::select("id","name")->whereNotIn("id",$id)->get()->toArray();
            }
        //获取所有商品
        $goodsInfo=$goods::with("goodsType")->get()->toArray();
        return view("admin.normsCombo.index", compact("normsComboInfos", "normsComboInfo", "goodsTypeInfo","count","info","goodsInfo","areaInfo"));
    }

    //添加sku
    public function create(Request $request,Goods $goods,NormsGroup $normsGroup,GoodsDetailsImg $goodsDetailsImg,GoodsImg $goodsImg,NormsCombo $normsCombo,Area $area)
    {
        $goodsID=$request->input("goods_id");
        $goodsInfo=$goods::find($goodsID)->toArray();
        //获取规格分组
        $normsGroupId=explode(",",$goodsInfo['f_norms_group_id']);
        $normsGroupInfo=$normsGroup::with(["norms"=>function($query) use ($goodsInfo)
        {
            $query->where('f_goods_type_id',$goodsInfo['f_goods_type_id']);
        }])->whereIn("id",$normsGroupId)->get()->toArray();
        //获取详情图
        $goodsDetailsImgInfo=$goodsDetailsImg::where("f_goods_id",$goodsID)->get()->toArray();
        foreach ($goodsDetailsImgInfo as $k=>$v)
        {
            $goodsDetailsImgInfo[$k]['url']="http://".$normsCombo->setCache($v['name']);
        }
        //获取规格图
        $goodsImgInfo=$goodsImg::where("f_goods_id",$goodsID)->get()->toArray();
        foreach ($goodsImgInfo as $k=>$v)
        {
            $goodsImgInfo[$k]['url']="http://".$normsCombo->setCache($v['name']);
            $goodsImgInfo[$k]['thumb_url']="http://".$normsCombo->setCache($v['thumb']);
        }
        //获取所有的地区
        $areaInfo=$area::all()->toArray();
        return view("admin.normsCombo.create",compact("normsGroupInfo","goodsDetailsImgInfo","goodsImgInfo","goodsInfo","areaInfo"));
    }
    //创建sku
    public function add(NormsComboRequest $request,NormsCombo $normsCombo)
    {
        $data=$request->except("_token","norms","f_norms_image");
        $norms=$request->input("norms");
        $normsImg=$request->input("f_norms_image");
        ksort($norms);
        $data['f_norms_id']=implode(",",$norms);
        $ids = Area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
        $id = array_unique(explode(",",$ids["ids"]));
        $areaInfo = Area::select("id","name")->whereNotIn("id",$id)->get()->toArray();
        if ($data['f_area_id']==1)
        {
            dispatch(new NormsComboArea($data,$areaInfo,$normsImg));
        }else{
            $normsComboInfo=$normsCombo->create($data);
        }
        return redirect()->route("normsCombo.list")->with(["msg"=>"添加成功"]);

    }
    //编辑sku
    public function edit(Goods $goods,NormsGroup $normsGroup,GoodsDetailsImg $goodsDetailsImg,GoodsImg $goodsImg,NormsCombo $normsCombo,Area $area,RelationNormsComboGoodsImg $relationNormsComboGoodsImg,$id)
    {
        $normsComboInfo=$normsCombo::find($id)->toArray();
        $goodsID=$normsComboInfo["f_goods_id"];
        $goodsInfo=$goods::find($goodsID)->toArray();
        //获取规格分组
        $normsGroupId=explode(",",$goodsInfo['f_norms_group_id']);
        $normsGroupInfo=$normsGroup::with(["norms"=>function($query) use ($goodsInfo)
        {
            $query->where('f_goods_type_id',$goodsInfo['f_goods_type_id']);
        }])->whereIn("id",$normsGroupId)->get()->toArray();
        //获取详情图
        $goodsDetailsImgInfo=$goodsDetailsImg::where("f_goods_id",$goodsID)->get()->toArray();
        foreach ($goodsDetailsImgInfo as $k=>$v)
        {
            $goodsDetailsImgInfo[$k]['url']="http://".$normsCombo->setCache($v['name']);
        }
        //获取规格图
        $goodsImgInfo=$goodsImg::where("f_goods_id",$goodsID)->get()->toArray();
        foreach ($goodsImgInfo as $k=>$v)
        {
            $goodsImgInfo[$k]['url']="http://".$normsCombo->setCache($v['name']);
            $goodsImgInfo[$k]['thumb_url']="http://".$normsCombo->setCache($v['thumb']);
        }
        //获取组图
        $relationNormsComboGoodsImgInfo=$relationNormsComboGoodsImg->where('f_norms_combo_id',$id)->get()->toArray();
        $relationNormsComboGoodsImgInfos=[];
        foreach ($relationNormsComboGoodsImgInfo as $k=>$v)
        {
            $relationNormsComboGoodsImgInfos[]=$v['f_goods_img_id'];
        }
        //获取所有的地区
        $areaInfo=$area::all()->toArray();
        $normsComboInfo['f_norms_id']=explode(",",$normsComboInfo['f_norms_id']);
        return view("admin.normsCombo.edit",compact("normsGroupInfo","goodsDetailsImgInfo","goodsImgInfo","goodsInfo","areaInfo","normsComboInfo","relationNormsComboGoodsImgInfos"));
    }
    //更新sku
    public function update(NormsComboRequest $request,NormsCombo $normsCombo,RelationNormsComboGoodsImg $relationNormsComboGoodsImg,$id)
    {
        $data=$request->except("_token","norms","f_norms_image");
        $norms=$request->input("norms");
        ksort($norms);
        $data['f_norms_id']=implode(",",$norms);
        $normsComboInfo=$normsCombo::find($id)->toArray();
        $normsCombo::find($id)->update($data);
        $normsImg=$request->input("f_norms_image");
        //更新norms
        $relationNormsComboGoodsImg->where("f_norms_combo_id",$id)->delete();
        foreach ($normsImg as $k=>$v)
        {
            $temp['f_norms_combo_id']=$id;
            $temp['f_goods_img_id']=$v;
            $relationNormsComboGoodsImg->create($temp);
        }
        dispatch(new NormsComboEdit($normsComboInfo));
        $ids = Area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
        $id = array_unique(explode(",",$ids["ids"]));
        $areaInfo = Area::select("id","name")->whereNotIn("id",$id)->get()->toArray();
        return redirect()->route("normsCombo.list")->with(["msg"=>"更新成功"]);
    }
    //删除sku
    public function delete(NormsCombo $normsCombo,$id)
    {
        $normsCombo::destroy($id);
        return json(200,"删除成功");
    }

    //sku导出
    public function export(NormsCombo $normsCombo,Norms $norms,GoodsType $goodsType,Request $request,Goods $goods,Area $area)
    {
        //搜索
        $info['name'] = $request->input("name") ? $request->input("name") : "";
        $info['type'] = $request->input("type") ? $request->input("type") : 0;
        $info['category'] = $request->input("category") ? $request->input("category") : 0;
        $info['f_area_id']=$request->input("f_area_id")?$request->input("f_area_id"):1;
        if (!$info['type'])
        {
            $types=$goodsType::all()->toArray();
            $type=[];
            foreach ($types as $k=>$v)
            {
                $type[]=$v['id'];
            }
        }else
        {
            if (!$info['category'])
            {
                $types=$goodsType->where("parent_id",$info['type'])->get()->toArray();
                $type=[];
                foreach ($types as $k=>$v)
                {
                    $type[]=$v['id'];
                }
            }else
            {
                $type=[$info['category']];
            }
        }
        //获取商品ID
        $goodsIds=$goods::where("open_id","like","%{$info['name']}%")->whereIn("f_goods_type_id",$type)->get()->toArray();
        $goodsId=[];
        foreach ($goodsIds as $k=>$v)
        {
            $goodsId[]=$v['id'];
        }
        $normsComboInfos = $normsCombo::with("goods", "goodsImg","area")->where("f_area_id",$info['f_area_id'])->whereIn("f_goods_id",$goodsId)->get();
        $count=$normsCombo->count();
        $normsComboInfo = $normsComboInfos->toArray();
        foreach ($normsComboInfo as $k => $v) {
            $normsComboInfo[$k]['norms'] = $norms->whereIn("id", explode(",", $v['f_norms_id']))->get()->toArray();
            $normsComboInfo[$k]['thumb_url'] = "http://" . $normsCombo->setCache($v['goods_img']['name']);
            $goodsTypeInfo = $goodsType::find($v['goods']['f_goods_type_id']);
            if ($goodsTypeInfo) {
                $normsComboInfo[$k]['category'] = $goodsTypeInfo->name;
                $normsComboInfo[$k]['type'] = $goodsType::find($goodsTypeInfo->parent_id)->name;
            } else {
                $normsComboInfo[$k]['category'] = "未知";
                $normsComboInfo[$k]['type'] = "未知";
            }
        };
        $goodsTypeInfo = make_tree($goodsType::all()->toArray());
//        dd($normsComboInfo['data']);
        $areaInfo=$area::where("parent_id",0)->get()->toArray();
        //获取所有商品
        $goodsInfo=$goods::with("goodsType")->get()->toArray();

        //整成一维数组
        $data[]=[
            '商品名称',
            '所属类型',
            '商品品类',
            '商品规格',
            '库存数量',
            '单价',
            '单价(11121)',
            '售价',
            '售价(11121)',
            '地区',
        ];
        foreach ($normsComboInfo as $k=>$v){
            $temp['open_id'] = $v['goods']['open_id'];
            $temp['type'] = $v['type'];
            $temp['category'] = $v['category'];
            $temp['name'] = "";
            foreach ($v['norms'] as $kk=>$vv){
                $temp['name'] .= $vv['name']."|";
            }
            $temp['name'] = trim($temp['name'],"|");
            $temp['stock'] = $v['stock'];
            $temp['piece_price'] = $v['piece_price'];
            $temp['small_piece_price'] = $v['small_piece_price'];
            $temp['single_price'] = $v['single_price'];
            $temp['sale_single_price'] = $v['sale_single_price'];
            $temp['area_name'] = $v['area']['name'];
            $data[] = $temp;
        }

        Excel::create('normsCombo',function($excel) use ($data){
            $excel->sheet('normsCombo', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');

    }
    //修改折扣价
    public function status(Request $request,NormsCombo $normsCombo,Area $area,$id)
    {
        $discount = $request->input("discount")/10;  //接收的折扣
        $Info = $normsCombo::select("f_norms_id","f_goods_id","f_area_id")->where("id",$id)->first()->toArray();   //修改的商品
        $normsComboInfo = $normsCombo->where("f_area_id",1)->where("f_norms_id",$Info["f_norms_id"])->where("f_goods_id",$Info["f_goods_id"])->first()->toArray();
        $single_price = $normsComboInfo["single_price"];
        $sale_single_price = $normsComboInfo["sale_single_price"];
        $piece_price = $normsComboInfo["piece_price"];
        $small_piece_price = $normsComboInfo["small_piece_price"]; //北京的价格
        //判断
        $temp[] = [];
        if ($Info["f_area_id"] != 1){
            $temp["discount"] = $discount;
            $temp["single_price"] = round($single_price*$discount,2);
            $temp["sale_single_price"] = round($sale_single_price*$discount,2);
            $piecePrice=round(floatval($piece_price)*$discount,2).preg_replace("/[0-9\.]/",'',$piece_price);
            $temp["piece_price"] = $piecePrice;
            $smallPiecePrice = round(floatval($small_piece_price)*$discount,2).preg_replace("/[0-9\.]/",'',$small_piece_price);
            $temp["small_piece_price"] = $smallPiecePrice;
            $res = $normsCombo::find($id)->update($temp);
            if ($res){
                return json(200,"折扣修改成功,稍后为您更新");
            }
        }else{
            return json(400,"北京的商品折扣不能修改,请您重新选择地区");
        }
    }

    //商品上下架
    public function goodStatus(NormsCombo $normsCombo,$id)
    {
        $normsComboInfo = $normsCombo::find($id);
//        dd($normsComboInfo);
        if($normsComboInfo->f_goods_status_id==0)
        {
            $normsComboInfo->f_goods_status_id = 1;
            $normsComboInfo->save();
            return json(200,"上架成功");
        }
        if($normsComboInfo->f_goods_status_id == 1)
        {
            $normsComboInfo->f_goods_status_id = 0;
            $normsComboInfo->save();
            return json(200,"下架成功");
        }
        return json(200,"商品状态不可更改");
    }
}
