<?php

namespace App\Http\Controllers\Admin;

use App\Model\AreaDiscount;
use App\Http\Requests\AreaPriceRequest;
use App\Jobs\NormsComboPrice;
use App\Model\Area;
use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AreaPriceController extends Controller
{
    //地区折扣列表
    public function index(Area $area,NormsCombo $normsCombo,AreaDiscount $areaDiscount,Request $request)
    {
        //搜索的地区
        $info["f_area_id"] = $request->input("f_area_id")?$request->input("f_area_id"):0;
        //搜索的折扣
        $info["discount"] = $request->input("discount")?$request->input("discount"):"";
        //过滤省份
        $ids = $area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
        $id = array_unique(explode(",",$ids["ids"]));
        //查询所有的市
        $areaInfo = $area::select("id","name")->whereNotIn("id",$id)->get()->toArray();
        //数据库查询
        if($info["f_area_id"] == 0){
            $areaDiscountInfos = $areaDiscount::with("area")->select("id","f_area_id","discount")->paginate(15);
        }
        if($info["f_area_id"]){
            $areaDiscountInfos = $areaDiscount::with("area")->select("id","f_area_id","discount")->where("f_area_id",$info["f_area_id"])->paginate(15);
        }
        $areaDiscountInfo = $areaDiscountInfos->toArray();
        return view("admin.areaPrice.index",compact("info","areaInfo","areaDiscountInfo","areaDiscountInfos"));
    }
    //地区折扣录入
    public function create(Area $area)
    {
        $ids = Area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
        $id = array_unique(explode(",",$ids["ids"]));
        //判断地区 北京录所有 河南录河南
        if(session("employeeInfo")["f_area_id"] == 1){
            $areaInfo = Area::select("id","name")->whereNotIn("id",$id)->where("id","!=","1")->get()->toArray();
        }else{
            $areaInfo = Area::select("id","name")->where("id",session("employeeInfo")["f_area_id"])->whereNotIn("id",$id)->where("id","!=","1")->orWhere("parent_id",session("employeeInfo")["f_area_id"])->get()->toArray();
        }
        return view("admin.areaPrice.create",compact("areaInfo"));
    }
    //处理折扣录入
    public function add(AreaPriceRequest $request,AreaDiscount $areaDiscount)
    {
        $data["f_area_id"] = $request->input("area");
        $data["discount"] = $request->input("discount")/10;
        $id = AreaDiscount::select("id")->where("f_area_id", $data["f_area_id"])->get()->toArray();
        if ($id) {
            $id = $id[0]["id"];
            $areaDiscount::find($id)->update($data);
        }else{
            $areaDiscount->create($data);
        }
       $area = $request->input("area");
        $discount = $request->input("discount")/10;
       dispatch(new NormsComboPrice($area,$discount));
       return redirect()->route("areaPrice.list")->with(["msg"=>"商品价格录入成功,稍后为您更新"]);
    }
}
