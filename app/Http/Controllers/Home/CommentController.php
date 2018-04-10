<?php

namespace App\Http\Controllers\Home;

use App\Model\Goods;
use App\Model\GoodsEvaluate;
use App\Model\GoodsImg;
use App\Model\NormsCombo;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\ShopCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends Controller
{
    //评价中心
    public function index(Request $request,Order $order,NormsCombo $normsCombo,Goods $goods,OrderGoods $orderGoods,$type=0)
    {
        //获取热卖推荐
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->whereIn("id",[563,647,645,567])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            $goodsInfo[$k]["image_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);
        }
        if ($type==0)
        {
            $orderInfos=$order::with("orderGoods","area")->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[14,15])->orderBy("id","desc")->paginate(5);
        }elseif ($type==1)
        {
            $orderInfos=$order::with("orderGoods","area")->whereHas("orderGoods",function($query)
            {
                $query->where("is_evaluate",0);
            })->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[14,15])->orderBy("id","desc")->paginate(5);
        }elseif($type==2)
        {
            $orderInfos=$order::with("orderGoods","area")->whereDoesntHave("orderGoods",function($query)
            {
                $query->where("is_evaluate",0);
            })->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[14,15])->orderBy("id","desc")->paginate(5);
        }else{
            $orderInfos=$order::with("orderGoods","area")->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[14,15])->orderBy("id","desc")->paginate(5);
        }
        $orderInfo=$orderInfos->toArray();
        if ($orderInfo['data'])
        {
            foreach ($orderInfo['data'] as $k=>$v)
            {
                //判断这个订单是否被评价过
                if ($v['f_order_form_status_id']==14||$v['f_order_form_status_id']==15)
                {
                    if (OrderGoods::where([['f_order_form_no',$v['no']],['is_evaluate',0]])->get()->toArray())
                    {
                        $orderInfo['data'][$k]['is_evaluate']=0;
                    }else{
                        $orderInfo['data'][$k]['is_evaluate']=1;
                    }
                }else{
                    $orderInfo['data'][$k]['is_evaluate']=0;
                }
                foreach ($v['order_goods'] as $k1=>$v1)
                {
                    //获取商品的图片
                    $goodsImg=$normsCombo::with('goodsImg')->where([["f_area_id",1],["f_goods_id",$v1['f_goods_id']],["f_norms_id","{$v1["f_norms_id"]}"]])->first()->toArray();
                    $orderInfo['data'][$k]['order_goods'][$k1]["img_url"]="http://".$normsCombo->setCache($goodsImg['goods_img']['thumb']);
                    $orderInfo['data'][$k]['order_goods'][$k1]["name"]=$goods->select("name")->where("id",$goodsImg['f_goods_id'])->first()->toArray()["name"];
                }
            }
        }else
        {
            $orderInfo['data']=[];
        }
        $noComment=$order::whereHas("orderGoods",function($query)
        {
            $query->where("is_evaluate",0);
        })->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[14,15])->count();
        $isComment=$order::whereDoesntHave("orderGoods",function($query)
        {
            $query->where("is_evaluate",0);
        })->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[14,15])->count();
        //获取已评价订单
        $index="comment";
        return view("home.comment.index",compact("index","orderInfo","orderInfos","goodsInfo","type","isComment","noComment"));
    }
    //评价商品页面
    public function info(Order $order,GoodsImg $goodsImg,Goods $goods,OrderGoods $orderGoods,NormsCombo $normsCombo,$no)
    {
        //获取热卖推荐
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->whereIn("id",[563,647,645,567])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            $goodsInfo[$k]["image_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);
        }
        //获取订单内的商品
        $orderGoodsInfo=$orderGoods::with("goods")->where([["f_order_form_no","$no"],["is_evaluate",0]])->get()->toArray();
        foreach ($orderGoodsInfo as $k=>$v)
        {
            $normsComboInfo=$normsCombo->where([["f_goods_id",$v['f_goods_id'],["f_norms_id","{$v['f_norms_id']}"]]])->first()->toArray();
            //获取商品图片
            $goodsImgInfo=$goodsImg->where("id","{$normsComboInfo['f_goods_img_id']}")->first();
            if ($goodsImgInfo){
                $goodsImgInfo=$goodsImgInfo->toArray();
                $orderGoodsInfo[$k]["image_url"]="http://".$normsCombo->setCache($goodsImgInfo['name']);
            }else{
                $orderGoodsInfo[$k]["image_url"]="";
            }
            $orderGoodsInfo[$k]["norms"]=$normsComboInfo;
        }
        //获取订单信息
        $orderInfo=$order->where('no',$no)->first()->toArray();
        $index="comment";
        return view("home.comment.info",compact("index","goodsInfo","orderGoodsInfo","orderInfo"));
    }
    //再次购买
    public function buy(Request $request,ShopCart $shopCart,OrderGoods $orderGoods,$no)
    {
        //查询订单
        $orderGoodsInfo=$orderGoods->where("f_order_form_no",$no)->get()->toArray();
        //查询是否已经添加过
        foreach ($orderGoodsInfo as $k=>$v){
            $shopCartInfo=$shopCart->where([["f_goods_id",$v["f_goods_id"]],["f_user_id",session("userInfo")['id']],["f_norms_combo_id",$v['f_norms_id']],["is_show",0]])->first();
            if ($shopCartInfo)
            {
                $shopCartInfo->number=$shopCartInfo->number+$v["number"];
                $shopCartInfo->save();
            }else
            {
                //如果没添加过该类型商品
                $shopCart->create(["f_goods_id"=>$v['f_goods_id'],"f_user_id"=>session("userInfo")['id'],"number"=>$v['number'],"f_norms_combo_id"=>$v['f_norms_id'],"is_show"=>0]);
            }
        }
        return redirect("shopCart/index");
    }
    //评价订单
    public function comment(Request $request,Order $order,OrderGoods $orderGoods,GoodsEvaluate $goodsEvaluate)
    {
        $data=$request->input("name");
        //查找订单
        $orderInfo=$order->where([['no',$data['no']],["f_user_id",session("userInfo")['id']]])->whereIn("f_order_form_status_id",[14,15])->first();
        if (!$orderInfo){
            return json(404,"订单不存在","fail");
        }
        foreach ($data['data'] as $k=>$v){
            //修改订单为已评价
            $orderGoodsInfo=$orderGoods::find($v['ids']);
            $orderGoodsInfo->is_evaluate=1;
            $orderGoodsInfo->save();
            //添加评价
            $info['content']=$v['cont'];
            $info['favor_degree']=$v['xing'];
            $info['f_goods_id']=$orderGoodsInfo->f_goods_id;
            $info['f_order_goods_id']=$v['ids'];
            $info['f_user_id']=session("userInfo")['id'];
            $info['f_user_name']=session("userInfo")['username'];
            $info['create_time']=time();
            $goodsEvaluate->create($info);
        }
        return json(200,"评价成功");
    }
    //评价展示页面
    public function lists(GoodsImg $goodsImg,GoodsEvaluate $goodsEvaluate,Order $order,OrderGoods $orderGoods,Goods $goods,NormsCombo $normsCombo,$no)
    {
        //获取热卖推荐
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->whereIn("id",[563,647,645,567])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            if (isset($v["goods_img"][0]["name"])){
                $goodsInfo[$k]["image_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);
            }else{
                $goodsInfo[$k]["image_url"]="";
            }
        }
        //获取订单信息
        $orderInfo=$order->where("no",$no)->first()->toArray();
        //查询这个订单的评论
        $id=$orderGoods->where([["f_order_form_no",$no],["is_evaluate",1]])->select("id")->get()->toArray();
        $ids=[];
        foreach ($id as $k=>$v){
            $ids[]=$v['id'];
        }
        $goodsEvaluateInfo=$goodsEvaluate->whereIn("f_order_goods_id",$ids)->get()->toArray();
        foreach ($goodsEvaluateInfo as $k=>$v)
        {
            //获取商品名商品价格
            $goodsTempInfo=$goods->where("id",$v['f_goods_id'])->first();
            $goodsEvaluateInfo[$k]['name']=$goodsTempInfo->name;
            $goodsEvaluateInfo[$k]['price']=$goodsTempInfo->show_sale_price;
            //获取商品图片
            $goodsImgInfo=$goodsImg->where([['f_goods_id',$v['f_goods_id']],["is_lead","T"]])->first();
            if ($goodsImgInfo){
                $goodsEvaluateInfo[$k]['image_url']="http://".$normsCombo->setCache($goodsImgInfo->name);
            }else{
                $goodsEvaluateInfo[$k]['image_url']="";
            }
        }
        $index="comment";
        return view("home.comment.list",compact("index","goodsInfo","orderInfo","goodsEvaluateInfo"));
    }
}
