<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GoodsPackageRequest;
use App\Model\Goods;
use App\Model\GoodsPackage;
use App\Model\GoodsType;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\PackageNorms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Xujif\UcloudUfileSdk\UfileSdk;
use Illuminate\Support\Facades\Storage;

class GoodsPackageController extends Controller
{
    //套餐列表
    public function index(GoodsPackage $goodsPackage, NormsCombo $normsCombo, Request $request)
    {
        //搜索的值
        $info["name"] = $request->input("name") ? $request->input("name") : "";
        $info["status"] = $request->input("status");
        if($info["status"]===null||$info["status"]==3)
        {
            $info["status"] = [0,1];
        }else{
            $info["status"] = [$request->input("status")];
        }
        //判断 数据库查询
        $goodsPackageInfos = $goodsPackage->where("name", "like", "%{$info["name"]}%")->whereIn("status",$info["status"])->paginate(15);
        $goodsPackageInfo= $goodsPackageInfos->toArray();
        foreach ($goodsPackageInfo["data"] as $k => $v) {
                $goodsPackageInfo["data"][$k]["thumb_url"] = "http://" . $normsCombo->setCache($v["f_goods_img"]);
        }
        if(count($info["status"]) == 1)
        {
            $info["status"] = $request->input("status");
        }else{
            $info["status"] =3;
        }
        return view("admin/goodsPackage/index", compact("goodsPackageInfos", "goodsPackageInfo", "info"));
    }

    //添加套餐
    public function create(NormsCombo $normsCombo, GoodsPackage $goodsPackage,GoodsType $goodsType, Goods $goods, Norms $norms, Request $request)
    {
        $info["type"] = $request->input("type");
        //1.酒店专区
        if ($info["type"] == 0) {
            $goodsTypeId = 5;
        }
        //2.饭店专区
        if ($info["type"] == 1) {
            $goodsTypeId = 11;
        }
        $normsComboInfo = $normsCombo::with("goods")->whereHas("goods", function ($query) use ($goodsTypeId) {
            $query->where("f_goods_type_id", $goodsTypeId);
        })->get()->toArray();
        foreach ($normsComboInfo as $k => $v) {
            $normsComboInfo[$k]["norms"] = $norms->select(DB::raw("GROUP_CONCAT(name separator '|') as name"))->whereIn("id", explode(",", $v["f_norms_id"]))->first()->toArray()["name"];
        }
//        dd($normsComboInfo);
        return view("admin/goodsPackage/create", compact("normsComboInfo","info"));
    }
    //处理添加
    public function add(GoodsPackageRequest $request, PackageNorms $packageNorms,GoodsPackage $goodsPackage)
    {
        //1.接收添加的值
        $data = $request->only("name", "show_price", "show_sale_price", "status","type");
        $data["create_time"] = time();
        $goodsNormsIds = $request->only("f_goods_norms_id");
        //2.商品详情图
        $ufile = new UfileSdk(env("KOCKET"), "WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==", "2ee9865d56c51fe23890983e69811e3139c73029");
        if (!file_exists("images/goodsDetailsImg")) {
            mkdir("images/goodsDetailsImg", 0777, true);
            chmod("images/goodsDetailsImg", 0777);
        }
        $detailsName = make_rand_str() . ".jpg";
        $detailsName = Image::make($request->file("detailsImg"))->encode('jpg')->save("images/goodsDetailsImg/$detailsName")->basename;
        $ufile->putFile($detailsName, "images/goodsDetailsImg/$detailsName");
        $data["f_goods_details_img"] = $detailsName;
        //3.商品主图
        if (!file_exists("images/goodsImg")) {
            mkdir("images/goodsImg", 0777, true);
            chmod("images/goodsImg", 0777);
        }
        if (!file_exists("images/goodsImgSmall")) {
            mkdir("images/goodsImgSmall", 0777, true);
            chmod("images/goodsImgSmall", 0777);
        }
        $goodsImgName = make_rand_str() . ".jpg";
        $goodsImgName = Image::make($request->file("masterImg"))->encode('jpg')->save("images/goodsImg/$goodsImgName")->basename;
        $goodsImgNameSmall = Image::make($request->file("masterImg"))->resize(350, 350)->encode('jpg')->save("images/goodsImgSmall/s_$goodsImgName")->basename;
        $ufile->putFile($goodsImgName, "images/goodsImg/$goodsImgName");
        $ufile->putFile($goodsImgNameSmall, "images/goodsImgSmall/$goodsImgNameSmall");

        $data["f_goods_img"] = $goodsImgName;
        $data["f_goods_thumb_img"] = $goodsImgNameSmall;
        $res = $goodsPackage->create($data)->toArray();
        $goodsPackageId = $res["id"];
        //循环添加 package_norms表
        foreach ($goodsNormsIds["f_goods_norms_id"] as $k=>$v)
        {
            $packageNormsData["f_goods_package_id"] = $goodsPackageId;
            $packageNormsData["f_goods_norms_id"] = $v;
            $packageNorms->create($packageNormsData);
        }
        return redirect()->route("goodsPackage.list")->with(["msg" => "添加成功"]);
    }
    //修改套餐
    public function edit(GoodsPackage $goodsPackage,NormsCombo $normsCombo,Goods $goods,Norms $norms,Request $request,PackageNorms $packageNorms, $id)
    {
        $goodsPackageInfo = $goodsPackage::find($id)->toArray();
        $packageNormsInfo = $packageNorms->where("f_goods_package_id",$id)->get()->toArray();
        $goodsNormsId = [];
        foreach ($packageNormsInfo as $k=>$v)
        {
            $goodsNormsId[] = $v["f_goods_norms_id"];
        }
        $info["type"] = $goodsPackageInfo["type"];
        //1.酒店专区
        if($info["type"] == 0)
        {
            $goodsTypeId = 5;
        }
        //2.饭店专区
        if($info["type"] == 1)
        {
            $goodsTypeId = 11;
        }
        //获取normsCombo
        $normsComboInfo = $normsCombo::with("goods")->whereHas("goods",function ($query) use($goodsTypeId){
            $query->where("f_goods_type_id",$goodsTypeId);
        })->get()->toArray();
        //强加norms
        foreach ($normsComboInfo as $k => $v) {
            $normsComboInfo[$k]["norms"] = $norms->select(DB::raw("GROUP_CONCAT(name separator '|') as name"))->whereIn("id", explode(",", $v["f_norms_id"]))->first()->toArray()['name'];
        }
        return view("admin/goodsPackage/edit", compact("goodsPackageInfo","normsComboInfo","goodsNormsId"));
    }

    //处理修改
    public function update(GoodsPackage $goodsPackage, PackageNorms $packageNorms,Request $request, $id)
    {
        //接收修改的值
        $data = $request->only("name", "show_price", "show_sale_price", "status");
        $data["update_time"] = time();
        $goodsNormsIds = $request->only("f_goods_norms_id");
//        dd($goodsNormsIds);
        //2.商品详情图
        $ufile = new UfileSdk(env("KOCKET"), "WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==", "2ee9865d56c51fe23890983e69811e3139c73029");
        if ($request->file("detailsImg")) {
            if (!file_exists("images/goodsDetailsImg")) {
                mkdir("images/goodsDetailsImg", 0777, true);
                chmod("images/goodsDetailsImg", 0777);
            }
            $detailsName = make_rand_str() . ".jpg";
            $detailsName = Image::make($request->file("detailsImg"))->encode('jpg')->save("images/goodsDetailsImg/$detailsName")->basename;
            $ufile->putFile($detailsName, "images/goodsDetailsImg/$detailsName");
            $data['f_goods_details_img'] = $detailsName;
        }
        //3.保存商品主图
        if ($request->file("masterImg")) {
            if (!file_exists("images/goodsImg")) {
                mkdir("images/goodsImg", 0777, true);
                chmod("images/goodsImg", 0777);
            }
            if (!file_exists("images/goodsImgSmall")) {
                mkdir("images/goodsImgSmall", 0777, true);
                chmod("images/goodsImgSmall", 0777);
            }
            $goodsImgName = make_rand_str() . ".jpg";
            $goodsImgName = Image::make($request->file("masterImg"))->encode('jpg')->save("images/goodsImg/$goodsImgName")->basename;
            $goodsImgNameSmall = Image::make($request->file("masterImg"))->resize(350, 350)->encode('jpg')->save("images/goodsImgSmall/s_$goodsImgName")->basename;
            $ufile->putFile($goodsImgName, "images/goodsImg/$goodsImgName");
            $ufile->putFile($goodsImgNameSmall, "images/goodsImgSmall/$goodsImgNameSmall");
            $data["f_goods_img"] = $goodsImgName;
            $data["f_goods_thumb_img"] = $goodsImgNameSmall;
        }
        //添加goodsPackage表
        $goodsPackageInfo = $goodsPackage::find($id)->update($data);
        //添加package_norms表 先删除再添加
        $packageNorms->where("f_goods_package_id",$id)->delete();
        foreach ($goodsNormsIds["f_goods_norms_id"] as $k=>$v)
        {
            $packageNormsData["f_goods_package_id"] = $id;
            $packageNormsData["f_goods_norms_id"] = $v;
            $packageNormsInfo = $packageNorms->create($packageNormsData);
        }
        return redirect()->route("goodsPackage.list")->with(["msg" => "修改成功"]);
    }

    //删除套餐
    public function delete(GoodsPackage $goodsPackage, PackageNorms $packageNorms,$id)
    {
        $goodsPackage::destroy($id);
        $packageNorms->where("f_goods_package_id",$id)->delete();
        return json(200, "删除成功");
    }

    //上下架状态
    public function status(GoodsPackage $goodsPackage,$id)
    {
        $goodsPackageInfo = $goodsPackage::find($id);
        if($goodsPackageInfo->status == 0)
        {
            $goodsPackageInfo->status = 1;
            $goodsPackageInfo->save();
            return json(200,"下架成功");
        }
        if($goodsPackageInfo->status == 1)
        {
            $goodsPackageInfo->status = 0;
            $goodsPackageInfo->save();
            return json(200,"上架成功");
        }
    }

    //套餐详情
    public function info(GoodsPackage $goodsPackage,PackageNorms $packageNorms,$id)
    {
        $goodsPackageInfo = $goodsPackage::find($id)->toArray();
//        dd($goodsPackageInfo);
        return view("admin/goodsPackage/info",compact("goodsPackageInfo"));
    }
}
