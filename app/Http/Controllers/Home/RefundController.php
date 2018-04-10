<?php

namespace App\Http\Controllers\Home;

use App\Model\Goods;
use App\Model\NormsCombo;
use App\Model\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    //退款首页
    public function index(Order $order,NormsCombo $normsCombo,Goods $goods)
    {
      $orderInfos=$order::with('orderGoods')->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",[6,7])->orderBy("id","desc")->paginate(5);
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
        $index="refund";
        return view("home.refund.index",compact("index","orderInfo","orderInfos"));
    }
    //退款进度
    public function info(Order $order,$no)
    {
        $orderInfo=$order->where([["no",$no],['f_user_id',session("userInfo")['id']]])->first();
        if (!$orderInfo){
            return back()->with(["msg"=>"对不起,订单不存在"]);
        }
        $index="refund";
        $orderInfo=$orderInfo->toArray();
        if ($orderInfo['f_order_form_status_id']==2){
            return view("home.refund.stepOne",compact("index","orderInfo"));
        }else if($orderInfo['f_order_form_status_id']==6){
            return view("home.refund.stepTwo",compact("index","orderInfo"));
        }else if($orderInfo['f_order_form_status_id']==7){
            return view("home.refund.stepThr",compact("index","orderInfo"));
        }else{
            return back();
        }
    }
    //处理退款
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
        if ($orderInfo->f_order_form_status_id!=2)
        {
            return back()->with(["msg"=>"对不起,订单不允许退款"]);
        }
        $orderInfo->refund_reason=$return_goods_reason;
        $orderInfo->refund_explain=$return_goods_explain;
        $orderInfo->f_order_form_status_id=6;
        $orderInfo->refund_time=time();
        if ($orderInfo->save())
        {
            return redirect("refund/info/{$no}");
        }
        return back();
    }
    //撤销退款
    public function repeal(Order $order,$no)
    {
        $orderInfo=$order->where("no",$no)->first();
        if (!$orderInfo){
            return back()->with(["msg"=>"对不起,订单不存在"]);
        }
        if ($orderInfo->f_order_form_status_id!=6)
        {
            return back()->with(["msg"=>"对不起,订单不允许撤销"]);
        }
        $orderInfo->return_goods_reason="";
        $orderInfo->return_goods_explain="";
        $orderInfo->f_order_form_status_id=2;
        if ($orderInfo->save())
        {
            return redirect("order/index")->with(["msg"=>"撤销退款成功"]);
        }
        return back();
    }
}
