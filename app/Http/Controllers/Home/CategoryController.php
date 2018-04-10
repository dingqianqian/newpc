<?php

namespace App\Http\Controllers\Home;

use App\Model\Goods;
use App\Model\GoodsType;
use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //二级分类页面（酒店）
    public function hotel(Goods $goods,NormsCombo $normsCombo,$id)
    {
        //获取所有商品
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->where([["f_goods_type_id","$id"],["f_goods_status_id","!=","5"]])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            if (isset($v["goods_img"][0]["name"])){
                $goodsInfo[$k]["image_url"]=$normsCombo->setCache($v["goods_img"][0]["name"]);
            }else{
                $goodsInfo[$k]["image_url"]="";
            }
        }
        return view("home.category.hotel",compact("goodsInfo","id"));
    }
    //二级分类页面（饭店）
    public function house(Goods $goods,NormsCombo $normsCombo,$id)
    {
        //获取所有商品
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->where([["f_goods_type_id","$id"],["f_goods_status_id","!=","5"]])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            if (isset($v["goods_img"][0]["name"])){
                $goodsInfo[$k]["image_url"]=$normsCombo->setCache($v["goods_img"][0]["name"]);
            }else{
                $goodsInfo[$k]["image_url"]="";
            }
        }
        return view("home.category.house",compact("goodsInfo","id"));
    }
    //二级分类页面（居家）
    public function home(Goods $goods,NormsCombo $normsCombo,$id)
    {
        //获取所有商品
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->where([["f_goods_type_id","$id"],["f_goods_status_id","!=","5"]])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            if (isset($v["goods_img"][0]["name"])){
                $goodsInfo[$k]["image_url"]=$normsCombo->setCache($v["goods_img"][0]["name"]);
            }else{
                $goodsInfo[$k]["image_url"]="";
            }
        }
        return view("home.category.home",compact("goodsInfo","id"));
    }
    //耳机分类页面（品牌）
    public function brand(Goods $goods,NormsCombo $normsCombo,GoodsType $goodsType,$id)
    {
        //获取所有商品
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->where([["f_goods_type_id","$id"],["f_goods_status_id","!=","5"]])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            if (isset($v["goods_img"][0]["name"])){
                $goodsInfo[$k]["image_url"]=$normsCombo->setCache($v["goods_img"][0]["name"]);
            }else{
                $goodsInfo[$k]["image_url"]="";
            }
        }
        $goodsTypeInfo=$goodsType->where("id",$id)->first()->toArray();
        //获取所有品牌
        return view("home.category.brand",compact("goodsInfo","id","goodsTypeInfo"));
    }
}
