<?php

namespace App\Http\Controllers\Home;

use App\Model\AddValueTax;
use App\Model\InvoiceOrder;
use App\Model\InvoiceTitle;
use App\Model\Order;
use App\Model\Recharge;
use App\Model\TakeOver;
use App\Model\UserRecharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    //发票管理首页
    public function index(InvoiceTitle $invoiceTitle,TakeOver $takeOver,Order $order,Recharge $recharge,UserRecharge $userRecharge,InvoiceOrder $invoiceOrder)
    {
        //获取用户所有的发票抬头
        $invoiceTitleInfo=$invoiceTitle->where("f_user_id",session("userInfo")["id"])->get()->toArray();
        //收货地址
        $takeOverInfo=$takeOver->getAll(session("userInfo")["id"]);
        //获取可开发票订单
        $orderInfo=$order->getInvoiceOrder(session("userInfo")['id']);
        //获取钱包可开发票金额
        $id=session("userInfo")["id"];
        //1.获取用户的充值记录
        $price1=$recharge->where([["f_user_id",$id],["f_order_form_status_id",2]])->sum("price");
        //2.获取用户没有充值记录的钱
        $price2=$userRecharge->where("f_user_id",$id)->select("price")->first();
        if ($price2){
            $price2=$price2->price;
        }else{
            $price2=0;
        }
        $walletPrice=($price1+$price2)*100;
        //3.获取用户发票开的钱包的金额
        $invoice=$invoiceOrder->where("f_user_id",$id)->select(DB::raw("GROUP_CONCAT(f_order_form_id) as ids"))->first();
        if ($invoice){
            $invoice=$invoice->ids;
        }else{
            $invoice=0;
        }
        $invoice=explode(",",$invoice);
        //dd($invoice);
        //获取订单
        $orderPrice1=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10])->sum("price")*100;
        $orderPrice2=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[14,15,16])->sum("discount_price")*100;
        $orderPrice3=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10,14,15,16])->sum("virtual_discount")*100;
        $orderPrice=$orderPrice1+$orderPrice2-$orderPrice3;
        $price=($walletPrice-$orderPrice)/100;
        if ($price<=0){
            $price=0;
        }
        $index="invoice";
        return view("home.invoice.index",compact("index","invoiceTitleInfo","takeOverInfo","orderInfo","price"));
    }
    //普通发票索取
    public function addNormInvoive(Request $request,TakeOver $takeOver,InvoiceOrder $invoiceOrder,Order $order,InvoiceTitle $invoiceTitle,Recharge $recharge,UserRecharge $userRecharge)
    {
        //获取收货地址
        $takeOverInfo=$takeOver->where("id",$request->input("addId"))->first();
        if (!$takeOverInfo)
        {
            return json(404,"发票地址不存在","fail");
        }
        $data["receive_addr"]=$takeOverInfo->province.' '.$takeOverInfo->city.' '.$takeOverInfo->town.' '.$takeOverInfo->ex;
        $data['f_area_id']=$takeOverInfo->f_area_id;
        $data['f_user_signin_name']=session("userInfo")['signin_name'];
        $data['receive_name']=$takeOverInfo->name;
        $data['receive_tel']=$takeOverInfo->tel_no;
        $data['invoice_type']="普票";
        $data['create_time']=time();
        $data['f_user_id']=session("userInfo")['id'];
        $data['f_user_username']=session("userInfo")['username'];
        $data['no']=make_no();
        if ($request->input("invoice")==0)
        {
            $data['invoice_name']='个人';
            $data['tax_no']="";
        }else{
            $data['invoice_name']=$invoiceTitle::find($request->input("invoice"))->name;
            $data['tax_no']=$request->input('tax_no');
        }
        $data['f_order_form_id']=trim($request->input('f_order_form_id'),",");
        $ids=explode(",",trim($request->input('f_order_form_id'),","));
        $orderInfo=$order->whereIn("id",$ids)->get();
        foreach ($orderInfo as $k=>$v)
        {
            if ($v['is_need_invoice']==1)
            {
                return json(500,"有订单已经开过发票","fail");
            }
        }
        //1.获取用户的充值记录
        $id=session("userInfo")['id'];
        $price1=$recharge->where([["f_user_id",$id],["f_order_form_status_id",2]])->sum("price");
        //2.获取用户没有充值记录的钱
        $price2=$userRecharge->where("f_user_id",$id)->select("price")->first();
        if ($price2){
            $price2=$price2->price;
        }else{
            $price2=0;
        }
        $walletPrice=($price1+$price2)*100;
        //3.获取用户发票开的钱包的金额
        $invoice=$invoiceOrder->where("f_user_id",$id)->select(DB::raw("GROUP_CONCAT(f_order_form_id) as ids"))->first();
        if ($invoice){
            $invoice=$invoice->ids;
        }else{
            $invoice=0;
        }
        $invoice=explode(",",$invoice);
        //dd($invoice);
        //获取订单
        //获取订单
        $orderPrice1=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10])->sum("price")*100;
        $orderPrice2=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[14,15,16])->sum("discount_price")*100;
        $orderPrice3=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10,14,15,16])->sum("virtual_discount")*100;
        $orderPrice=$orderPrice1+$orderPrice2-$orderPrice3;
        $price=($walletPrice-$orderPrice)/100;
        //获取用户要开发票的订单价钱
        $priceTotal1=$order->whereIn("id",$ids)->whereIn("f_pay_type_id",[4,9,10])->sum("price");
        $priceTotal2=$order->whereIn("id",$ids)->whereIn("f_pay_type_id",[14,15,16])->sum("discount_price");
        $priceTotal=$priceTotal1+$priceTotal2;
        if ($priceTotal>$price){
            //获取订单钱包支付列表
            $orderInfo=$order::whereIn("f_pay_type_id",[4,9,10,14,15,16])->whereIn("id",$ids)->orderBy("price","desc")->first();
            $orderInfo->virtual_discount=$priceTotal-$price;
            $orderInfo->save();
        }
        //如果开发票成功
        if ($invoiceOrder->create($data))
        {
           if($order->whereIn("id",$ids)->update(["is_need_invoice"=>1]))
           {
               return json(200,"开取发票成功");
           };
        }
        return json(500,"未知错误","fail");
    }
    //增值税发票首页
    public function valueAddTax(AddValueTax $addValueTax,TakeOver $takeOver,Order $order,Recharge $recharge,InvoiceOrder $invoiceOrder,UserRecharge $userRecharge)
    {
        //判断如果用户没有认证过
        if ($addValueTaxInfo=$addValueTax->where("f_user_id",session("userInfo")['id'])->first()){
            $addValueTaxInfo=$addValueTaxInfo->toArray();
            //获取用户的收货地址
            $takeOverInfo=$takeOver->getAll(session("userInfo")['id']);
            //获取可开发票订单
            $orderInfo=$order->getInvoiceOrder(session("userInfo")['id']);
            //1.获取用户的充值记录
            $id=session("userInfo")['id'];
            $price1=$recharge->where([["f_user_id",$id],["f_order_form_status_id",2]])->sum("price");
            //2.获取用户没有充值记录的钱
            $price2=$userRecharge->where("f_user_id",$id)->select("price")->first();
            if ($price2){
                $price2=$price2->price;
            }else{
                $price2=0;
            }
            $walletPrice=($price1+$price2)*100;
            //3.获取用户发票开的钱包的金额
            $invoice=$invoiceOrder->where("f_user_id",$id)->select(DB::raw("GROUP_CONCAT(f_order_form_id) as ids"))->first();
            if ($invoice){
                $invoice=$invoice->ids;
            }else{
                $invoice=0;
            }
            $invoice=explode(",",$invoice);
            //dd($invoice);
            //获取订单
            //获取订单
            $orderPrice1=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10])->sum("price")*100;
            $orderPrice2=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[14,15,16])->sum("discount_price")*100;
            $orderPrice3=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10,14,15,16])->sum("virtual_discount")*100;
            $orderPrice=$orderPrice1+$orderPrice2-$orderPrice3;
            $price=($walletPrice-$orderPrice)/100;
            if ($price<=0){
                $price=0;
            }
            return view("home.invoice.start",compact("addValueTaxInfo","takeOverInfo","orderInfo","price"));
        }else
            {
                return view("home.invoice.stepOne");
            }

    }
    //增票资质信息
    public function info(AddValueTax $addValueTax)
    {
        //获取用户增票资质信息
        $addValueTaxInfo=$addValueTax->where("f_user_id",session("userInfo")['id'])->first();
        $addValueTaxInfo=$addValueTaxInfo?$addValueTaxInfo->toArray():null;
        return view("home.invoice.info",compact("addValueTaxInfo"));
    }
    //发票管理第二步
    public function stepTwo()
    {
        return view("home.invoice.stepTwo");
    }
    //增值税发票确认书
    public function authBook()
    {
        return view("home.invoice.contract");
    }
    //增值税发票索取
    public function addValueTax(Request $request,TakeOver $takeOver,InvoiceOrder $invoiceOrder,Order $order,AddValueTax $addValueTax,Recharge $recharge,UserRecharge $userRecharge)
    {
        //判断用户是否通过认证
        $addValueTaxInfo=$addValueTax->where("f_user_id",session("userInfo")['id'])->first();
        if (!$addValueTaxInfo)
        {
            return json(404,"认证信息不存在","fail");
        }
        if($addValueTaxInfo->status!=2)
        {
            return json(404,"认证信息未通过","fail");
        }
        //获取收货地址
        $takeOverInfo=$takeOver->where("id",$request->input("addId"))->first();
        if (!$takeOverInfo)
        {
            return json(404,"发票地址不存在","fail");
        }
        $data["receive_addr"]=$takeOverInfo->province.' '.$takeOverInfo->city.' '.$takeOverInfo->town.' '.$takeOverInfo->ex;
        $data['f_area_id']=$takeOverInfo->f_area_id;
        $data['f_user_signin_name']=session("userInfo")['signin_name'];
        $data['receive_name']=$takeOverInfo->name;
        $data['receive_tel']=$takeOverInfo->tel_no;
        $data['invoice_type']="专票";
        $data['create_time']=time();
        $data['f_user_id']=session("userInfo")['id'];
        $data['f_user_username']=session("userInfo")['username'];
        $data['no']=make_no();
        $data['invoice_name']=$addValueTaxInfo->company_name;
        $data['tax_no']=$addValueTaxInfo->tax_no;
        $data['f_order_form_id']=trim($request->input('f_order_form_id'),",");
        $ids=explode(",",trim($request->input('f_order_form_id'),","));
        $orderInfo=$order->whereIn("id",$ids)->get();
        foreach ($orderInfo as $k=>$v)
        {
            if ($v['is_need_invoice']==1)
            {
                return json(500,"有订单已经开过发票","fail");
            }
        }
        $id=session("userInfo")['id'];
        //1.获取用户的充值记录
        $price1=$recharge->where([["f_user_id",$id],["f_order_form_status_id",2]])->sum("price");
        //2.获取用户没有充值记录的钱
        $price2=$userRecharge->where("f_user_id",$id)->select("price")->first();
        if ($price2){
            $price2=$price2->price;
        }else{
            $price2=0;
        }
        $walletPrice=($price1+$price2)*100;
        //3.获取用户发票开的钱包的金额
        $invoice=$invoiceOrder->where("f_user_id",$id)->select(DB::raw("GROUP_CONCAT(f_order_form_id) as ids"))->first();
        if ($invoice){
            $invoice=$invoice->ids;
        }else{
            $invoice=0;
        }
        $invoice=explode(",",$invoice);
        //dd($invoice);
        //获取订单
        $orderPrice1=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10])->sum("price")*100;
        $orderPrice2=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[14,15,16])->sum("discount_price")*100;
        $orderPrice3=$order->whereIn("id",$invoice)->whereIn("f_pay_type_id",[4,9,10,14,15,16])->sum("virtual_discount")*100;
        $orderPrice=$orderPrice1+$orderPrice2-$orderPrice3;
        $price=($walletPrice-$orderPrice)/100;
        //获取用户要开发票的订单价钱
        $priceTotal1=$order->whereIn("id",$ids)->whereIn("f_pay_type_id",[4,9,10])->sum("price");
        $priceTotal2=$order->whereIn("id",$ids)->whereIn("f_pay_type_id",[14,15,16])->sum("discount_price");
        $priceTotal=$priceTotal1+$priceTotal2;
        if ($priceTotal>$price){
            //获取订单钱包支付列表
            $orderInfo=$order::whereIn("f_pay_type_id",[4,9,10,14,15,16])->whereIn("id",$ids)->orderBy("price","desc")->first();
            $orderInfo->virtual_discount=$priceTotal-$price;
            $orderInfo->save();
        }
        //如果开发票成功
        if ($invoiceOrder->create($data))
        {
            if($order->whereIn("id",$ids)->update(["is_need_invoice"=>1]))
            {
                return json(200,"开取发票成功");
            };
        }
        return json(500,"未知错误","fail");
    }
}
