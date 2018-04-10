<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\ByIdRequest;
use App\Http\Requests\IdsRequest;
use App\Http\Requests\JsonRequest;
use App\Model\Custom;
use App\Model\GoodsDetailsImg;
use App\Model\GoodsImg;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\NormsComboImg;
use App\Model\ShopCart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopCartController extends Controller
{
    //获取购物车商品列表
    public function index(ShopCart $shopCart,Norms $norms,NormsCombo $normsCombo,GoodsImg $goodsImg,Custom $custom)
    {
        //获取购物车商品信息
        $shopInfo=$shopCart->where([["f_user_id",session("userInfo")["id"]],["is_show","=",0]])->get()->toArray();
        //循环删除已经下架的商品
        foreach ($shopInfo as $k=>$v)
        {
            $normsComboInfo=$normsCombo::with("goods")->where([['f_goods_id',$v['f_goods_id']],["f_norms_id",$v['f_norms_combo_id']],["f_area_id",session("f_area_info")['id']]])->first();
            if (!$normsComboInfo)
            {
                $normsComboInfo=$normsCombo::with("goods")->where([['f_goods_id',$v['f_goods_id']],["f_norms_id",$v['f_norms_combo_id']],["f_area_id",1]])->first();
            }
            if ($normsComboInfo)
            {
                $normsComboInfo=$normsComboInfo->toArray();
                if ($normsComboInfo['f_goods_status_id']!=1||$normsComboInfo['goods']['f_goods_status_id']!=1)
                {
                    unset($shopInfo[$k]);
                    $shopCart::destroy($v['id']);
                }
            }else
                {
                    unset($shopInfo[$k]);
                    $shopCart::destroy($v['id']);
                }
        }
        if ($shopInfo)
        {
            foreach ($shopInfo as $k=>$v)
            {
                $temp=$normsCombo->getGoodsInfo($norms,$goodsImg,$v["f_goods_id"],$v["f_norms_combo_id"],session("f_area_info")['id']);
                $temp["cart"]=$v;
                $temp["cart"]['custom_name']=$custom->where("id",$v["f_custom_id"])->value("hotel_name");
                $temp["cart"]['custom_delete']=$custom->where("id",$v["f_custom_id"])->value("is_delete");
                $shopCartInfo[]=$temp;
            }
        }else
            {
                $shopCartInfo=[];
            }
        //过滤已经删除掉的商品
        $temp=[];
        foreach ($shopCartInfo as $k=>$v)
        {
            if (isset($v["err"]))
            {
                continue;
            }
            if($v['cart']['custom_delete'] !=0){
                $shopCart::destroy($v['cart']['id']);
                continue;
            }
            if ($v['goods']['f_goods_status_id']!=1)
            {
                $shopCart::destroy($v['cart']['id']);
                continue;
            }
            $temp[]=$v;

        }
        //dd($temp);
        $shopCartInfo=$temp;
        return view("home.shopcart.index",compact('shopCartInfo'));
    }

    /**
     * 获取单个用户购物车商品数量
     * @param ShopCart $shopCart
     * @return array
     */
    public function getCount(ShopCart $shopCart)
    {
        if (session("userInfo"))
        {
            $count=$shopCart->where([["f_user_id",session("userInfo")["id"]],["is_show",0]])->count();
        }else
            {
                $count=0;
            }
        return ["err"=>0,"count"=>$count];
    }

    /**
     * ajax删除购物车
     * @param ShopCart $shopCart
     * @return array
     */
    public function delShopCart(ShopCart $shopCart,ByIdRequest $request)
    {
        $info=$shopCart->where([["id",$request->input("id"),["f_user_id",session("userInfo")["id"]]]])->delete();
        if ($info)
        {
            return ["err"=>200,"msg"=>"删除成功"];
        }else
            {
                return ["err"=>500,"msg"=>"删除失败"];
            }
    }

    /**
     * 购物车删除多个商品
     * @param ShopCart $shopCart
     * @param IdsRequest $request
     * @return array
     */
    public function delShopCartMany(ShopCart $shopCart,IdsRequest $request)
    {
        $id=trim($request->input("id"),",");
        $id=explode(",",$id);
        $info=$shopCart->whereIn("id",$id)->where("f_user_id",session("userInfo")["id"])->delete();
        return ["err"=>200,"msg"=>"删除成功"];
    }

    /**
     * ajax更新购物车数量
     * @param JsonRequest $request
     * @param ShopCart $shopCart
     * @return array
     */
    public function ajaxUpdateCart(JsonRequest $request,ShopCart $shopCart)
    {

        $data=json_decode($request->input("info"),true);
        foreach ($data as $k=>$v)
        {
            $cart=$shopCart->where("f_user_id",session("userInfo")["id"])->find($k);
            if (!$cart)
            {
                return ["err"=>404,"msg"=>"更新失败"];
            }
            if ($v>99)
            {
                $v=99;
            }
            $cart->number=$v;
            if (!$cart->save())
            {
                return ["err"=>404,"msg"=>"更新失败"];
            }
        }
        return ["err"=>200,"msg"=>"更新成功"];
    }
    /*
     * 添加购物车
     */
    public function create(Request $request,ShopCart $shopCart,NormsCombo $normsCombo)
    {
        $data=$request->all();
        $data["f_user_id"]=session("userInfo")["id"];
        //查询库存
        $normsComboInfo=$normsCombo::where([["f_goods_id",$data["f_goods_id"]],["f_norms_id",$data['f_norms_combo_id']]])->first()->toArray();
        if ($data["number"]>$normsComboInfo['stock'])
        {
            return ["err"=>400,"msg"=>"商品已经告罄"];
        }
        if ($data["is_show"]==1)
        {
            if ($id=$shopCart->create($data))
            {
                return ["err"=>200,"msg"=>"添加购物车成功","id"=>$id->id];
            }
        }
        //查询是否已经添加过
        $shopCartInfo=$shopCart->where([["f_goods_id",$data["f_goods_id"]],["f_user_id",$data["f_user_id"]],["f_norms_combo_id",$data['f_norms_combo_id']],["is_show",0]])->first();
        if ($shopCartInfo)
        {
            $shopCartInfo->number=$shopCartInfo->number+$data["number"];
            if ($shopCartInfo->save())
            {
                return ["err"=>200,"msg"=>"添加购物车成功","id"=>$shopCartInfo->id];
            }
        }else
            {
                //如果没添加过该类型商品
                if ($id=$shopCart->create($data))
                {
                    return ["err"=>200,"msg"=>"添加购物车成功","id"=>$id->id];
                }
            }
    }
}
