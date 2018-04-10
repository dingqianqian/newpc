<?php

namespace App\Http\Controllers\Admin;

use App\Model\Goods;
use App\Model\InvoiceOrder;
use App\Model\Order;
use App\Model\Recharge;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //后台首页
    public function index(Recharge $recharge,User $user,Order $order,InvoiceOrder $invoiceOrder,Goods $goods)
    {
        //订单统计信息
        if (session("employeeInfo")['f_area_id']==1)
        {
            $orderInfo[1]=$order->where("f_order_form_status_id",2)->count();
            $orderInfo[2]=$order->where("f_order_form_status_id",3)->count();
            $orderInfo[3]=$order->whereIn("f_order_form_status_id",[14,15])->count();
            $orderInfo[4]=$order->whereIn("f_order_form_status_id",[6,10])->count();
            $orderInfo[6]=$order->where([["f_order_form_status_id",2],["is_reminder",">",0]])->count();
            //商品信息
            $goodsInfo[2]=$goods->count();
            //销售信息
            $sellInfo[1]=$order->whereIn("f_order_form_status_id",[2,4,5,14,15])->sum("price");
            $sellInfo[2]=$user->where("create_time",">",time()-3600*24)->count();
        }else{
            $orderInfo[1]=$order->where([["f_order_form_status_id",2],["f_area_id",session("employeeInfo")['f_area_id']]])->count();
            $orderInfo[2]=$order->where([["f_order_form_status_id",3],["f_area_id",session("employeeInfo")['f_area_id']]])->count();
            $orderInfo[3]=$order->where("f_area_id",session("employeeInfo")['f_area_id'])->whereIn("f_order_form_status_id",[14,15])->count();
            $orderInfo[4]=$order->where("f_area_id",session("employeeInfo")['f_area_id'])->whereIn("f_order_form_status_id",[6,10])->count();
            $orderInfo[6]=$order->where("f_area_id",session("employeeInfo")['f_area_id'])->where([["f_order_form_status_id",2],["is_reminder",">",0]])->count();
            //商品信息
            $goodsInfo[2]=$goods->count();
            //销售信息
            $sellInfo[1]=$order->where("f_area_id",session("employeeInfo")['f_area_id'])->whereIn("f_order_form_status_id",[2,4,5,14,15])->sum("price");
            $sellInfo[2]=$user->where("f_area_id",session("employeeInfo")['f_area_id'])->where("create_time",">",time()-3600*24)->count();
        }

        //pv/uv
        $baiduTongji = resolve('BaiduTongji');
        $today = date('Ymd');
        $yesterday = date('Ymd', strtotime('yesterday'));
        $result = $baiduTongji->getData([
            'method' => 'trend/time/a',
            'start_date' => $today,
            'end_date' => $today,
            'start_date2' => $yesterday,
            'end_date2' => $yesterday,
            'metrics' => 'pv_count,visitor_count',
            'max_results' => 0,
            'gran' => 'day',
        ]);
        return view("admin.index.index",compact("orderInfo","goodsInfo","sellInfo","result"));
    }
}
