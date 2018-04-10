<?php

namespace App\Http\Controllers\Home;

use App\Model\Goods;
use App\Model\NormsCombo;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnSaleController extends Controller
{
    //退货首页
    public function index(Order $order,NormsCombo $normsCombo,Goods $goods)
    {
        $orderInfos=$order::with('orderGoods')->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[10,11])->orderBy("id","desc")->paginate(5);
        $orderInfo=$orderInfos->toArray();
        if ($orderInfo['data'])
        {
            foreach ($orderInfo['data'] as $k=>$v)
            {
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
//        dd($orderInfo);
        $index="returnsale";
        return view("home.returnSale.index",compact("index","orderInfo","orderInfos"));
    }
    //退货进度
    public function info(Order $order,$no)
    {
        $orderInfo=$order->where([["no",$no],['f_user_id',session("userInfo")['id']]])->first();
        if (!$orderInfo){
            return back()->with(["msg"=>"对不起,订单不存在"]);
        }
        $index="returnsale";
        $orderInfo=$orderInfo->toArray();
        if ($orderInfo['f_order_form_status_id']==14||$orderInfo['f_order_form_status_id']==15){
            return view("home.returnSale.stepOne",compact("index","orderInfo"));
        }else if($orderInfo['f_order_form_status_id']==10){
            return view("home.returnSale.stepTwo",compact("index","orderInfo"));
        }else if($orderInfo['f_order_form_status_id']==11){
            return view("home.returnSale.stepThr",compact("index","orderInfo"));
        }else{
            return back();
        }
    }
    //处理退货
    public function manage(Request $request,Order $order)
    {
        $no=$request->input("no");
        $return_goods_reason=$request->input("cuoW");
        $return_goods_explain=$request->input("explain");
        //查询订单
        $orderInfo=$order->where("no",$no)->first();
        if (!$orderInfo){
            return back()->with(["msg"=>"对不起,订单不存在"]);
        }
        if (($orderInfo->f_order_form_status_id!=14)&&($orderInfo->f_order_form_status_id!=15))
        {
            return back()->with(["msg"=>"对不起,订单不允许退货"]);
        }
        $orderInfo->return_goods_reason=$return_goods_reason;
        $orderInfo->return_goods_explain=$return_goods_explain;
        $orderInfo->f_order_form_status_id=10;
        $orderInfo->return_goods_style=$request->input("fangS")?$request->input("fangS"):"速立派";
        $orderInfo->return_goods_time=time();
        if ($orderInfo->save())
        {
            return redirect("returnSale/info/{$no}");
        }
        return back();
    }
    //撤销退货
    public function repeal(Order $order,$no)
    {
        $orderInfo=$order->where("no",$no)->first();
        if (!$orderInfo){
            return back()->with(["msg"=>"对不起,订单不存在"]);
        }
        if ($orderInfo->f_order_form_status_id!=10)
        {
            return back()->with(["msg"=>"对不起,订单不允许撤销"]);
        }
        $orderInfo->return_goods_reason="";
        $orderInfo->return_goods_explain="";
        $orderInfo->f_order_form_status_id=14;
        if ($orderInfo->save())
        {
            return redirect("order/index")->with(["msg"=>"撤销退货成功"]);
        }
        return back();
    }
}
