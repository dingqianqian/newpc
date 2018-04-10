<?php

namespace App\Http\Controllers\Admin;

use App\Model\AddValueTax;
use App\Model\Area;
use App\Model\Coupon;
use App\Model\InvoiceOrder;
use App\Model\Norms;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\Recharge;
use App\Model\User;
use App\Model\UserRecharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Exporter\Exporter;

class InvoiceController extends Controller
{
    //发票列表
    public function index(AddValueTax $addValueTax, InvoiceOrder $invoiceOrder, Order $order, Recharge $recharge, UserRecharge $userRecharge, Request $request,Coupon $coupon,User $user,Area $area)
    {
        //搜索的日期
        $info['min_time'] = $request->input("min_time") ? strtotime(getTimeStamp($request->input("min_time"))) : 1420041600;
        $info['max_time'] = $request->input("max_time") ? strtotime(getTimeStamp($request->input("max_time"))) + 3600 * 24 - 1 : time();
        //搜索的价格
        if ($request->input("price")) {
            $info['price'] = $request->input("price");
            switch ($info['price']) {
                case 1:
                    $min_price = 0;
                    $max_price = 1000;
                    break;
                case 2:
                    $min_price = 1000;
                    $max_price = 5000;
                    break;
                case 3:
                    $min_price = 5000;
                    $max_price = 10000;
                    break;
                case 4:
                    $min_price = 10000;
                    $max_price = 1000000;
                    break;
                default:
                    $min_price = 0;
                    $max_price = 1000000;
                    break;
            }
        } else {
            $info['price'] = 0;
            $min_price = 0;
            $max_price = 1000000;
        }

        //搜索的发票状态
        if ($request->input("status")) {
            $info['status'] = $request->input("status");
            switch ($info['status']) {
                case 1:
                    $status = [0];
                    break;
                case 2:
                    $status = [1];
                    break;
                default:
                    $status = [0, 1];
                    break;
            }
        } else {
            $info['status'] = 0;
            $status = [0, 1];
        }
        //搜索的订单号/单位名称
        $info['no'] = $request->input("no") ? $request->input("no") : "";
        //搜索的手机号
        $info["receive_tel"] = $request->input("receive_tel")?$request->input("receive_tel"):"";
        //获取公司名称用户ID
        $userId = [];
        if (!is_numeric($info['no'])) {
            $userIdS = $addValueTax->where("company_name", "like", "%{$info['no']}%")->get()->toArray();
            foreach ($userIdS as $k => $v) {
                $userId[] = $v['f_user_id'];
            }
        }
        //获取所有员工的ID
        $employeeIDs = $user::whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
        $employeeID = [];
        foreach ($employeeIDs as $k => $v) {
            $employeeID[] = $v['id'];
            if (session("employeeInfo")['f_area_id'] != 1) {
                $areaIds = [];
                $areaInfo = $area->where("id", session("employeeInfo")['f_area_id'])->orWhere("parent_id", session("employeeInfo")['f_area_id'])->select('id')->get()->toArray();
                foreach ($areaInfo as $k => $v) {
                    $areaIds[] = $v['id'];
                }
                $employeeIDs = $user::whereNotIn("signin_name", employeePhone())->whereIn("f_area_id", $areaIds)->select("id")->get()->toArray();
            } else {
                $employeeIDs = $user::whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
            }
            $employeeID = [];
            foreach ($employeeIDs as $k => $v) {
                $employeeID[] = $v['id'];
            }
            //获取所有符合金额的发票ID
            $ids = $invoiceOrder::all()->toArray();
            $idz = [];
            $temp = "";
            $tempId = [];
            $tempP = [];
            foreach ($ids as $k => $v) {
                $tempId[$v['id']] = explode(",", $v['f_order_form_id']);
                $temp .= $v['f_order_form_id'] . ",";
            }
            $temp = explode(",", trim($temp, ","));
            $priceID = $order->whereIn("id", $temp)->get()->toArray();
            foreach ($priceID as $k => $v) {
                if (in_array($v['f_pay_type_id'], [14, 15, 16])) {
                    $tempP[$v['id']] = $v['discount_price'];
                } else {
                    $tempP[$v['id']] = $v['price'];
                }
            }
            foreach ($tempId as $k => $v) {
                $priceSum = 0;
                foreach ($v as $k1 => $v1) {
                    if (isset($tempP[$v1])) {
                        $priceSum += $tempP[$v1];
                    }
                }
                $tempId[$k] = $priceSum;
            }
            foreach ($tempId as $k => $v) {
                if ($v >= $min_price && $v <= $max_price) {
                    $idz[] = $k;
                }
            }
            //如果订单号/单位名称存在
            if ($info['no']) {
                //如果是搜索的订单号
                if (is_numeric($info['no'])) {

                    $invoiceOrderInfos = $invoiceOrder->select("id", "f_order_form_id", "receive_name", "receive_tel", "is_fixed", "invoice_type", "no")->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ['no', "like", "%{$info['no']}%"]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->where("receive_tel",'like',"%{$info["receive_tel"]}%")->orderBy('id', "desc")->paginate(15);
                    $countInvoice = $invoiceOrder->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ['no', "like", "%{$info['no']}%"]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->where("receive_tel",'like',"%{$info["receive_tel"]}%")->get()->toArray();
                } else {
                    $invoiceOrderInfos = $invoiceOrder->select("id", "f_order_form_id", "receive_name", "receive_tel", "is_fixed", "invoice_type", "no")->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn('f_user_id', $userId)->whereIn("id", $idz)->whereIn('is_fixed', $status)->orderBy('id', "desc")->whereIn("f_user_id", $employeeID)->where("receive_tel",'like',"%{$info["receive_tel"]}%")->paginate(15);
                    $countInvoice = $invoiceOrder->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn('f_user_id', $userId)->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->where("receive_tel",'like',"%{$info["receive_tel"]}%")->get()->toArray();
                }
            } else {
                $invoiceOrderInfos = $invoiceOrder->select("id", "f_order_form_id", "receive_name", "receive_tel", "is_fixed", "invoice_type", "no")->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->orderBy('id', "desc")->whereIn("f_user_id", $employeeID)->where("receive_tel",'like',"%{$info["receive_tel"]}%")->paginate(15);
                $countInvoice = $invoiceOrder->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->where("receive_tel",'like',"%{$info["receive_tel"]}%")->get()->toArray();
            }
            $priceCount = [];
            $invoiceOrderInfo = $invoiceOrderInfos->toArray();
            foreach ($invoiceOrderInfo['data'] as $k => $v) {
                //获取申请开票金额
                $temp = explode(",", $v['f_order_form_id']);
                $orderInfo = $order->whereIn("id", $temp)->get()->toArray();
                if ($orderInfo) {
                    $couponNo = [];
                    foreach ($orderInfo as $k1 => $v1) {
                        if ($v1['f_coupon_no']) {
                            $couponNo[] = $v1["f_coupon_no"];
                        }
                    }
                } else {
                    $couponNo = [];
                }
                $invoiceOrderInfo['data'][$k]['couponPrice'] = $coupon->whereIn("no", $couponNo)->sum("use_value");
                $invoiceOrderInfo['data'][$k]['price'] = $tempId[$v['id']];
            }
            foreach ($countInvoice as $k => $v) {
                if (in_array($v['id'], $idz)) {
                    $priceCount[] = $tempId[$v['id']];
                }
            }
            $priceCount = array_sum($priceCount);
            $count = count($countInvoice);
            $info["min_time"] = date("Y年m月d日", $info['min_time']);
            $info["max_time"] = date("Y年m月d日", $info['max_time']);
            return view("admin.invoice.index", compact("invoiceOrderInfo", "invoiceOrderInfos", "info", "priceCount", "count"));
        }
    }

    //发票详情
    public function info(Norms $norms, Recharge $recharge, UserRecharge $userRecharge, InvoiceOrder $invoiceOrder, Order $order, OrderGoods $orderGoods, $id)
    {
        $invoiceOrderInfo = $invoiceOrder::with(["addValueTax" => function ($query) {
            $query->where("status", 2);
        }])->find($id)->toArray();
        $orderId = explode(",", $invoiceOrderInfo['f_order_form_id']);
        $orderInfo = $order->whereIn('id', $orderId)->get()->toArray();
        $no = [];
        $price = 0;
        $wallet_price = 0;
        foreach ($orderInfo as $k => $v) {
            $no[] = $v['no'];
            if (in_array($v['f_pay_type_id'], [14, 15, 16])) {
                $price += $v['discount_price'];
            } else {
                $price += $v['price'];
            }
            $price -= $v['virtual_discount'];
            if (in_array($v['f_pay_type_id'], [4, 9, 10])) {
                $wallet_price += $v['price'];
            }
        }
        $invoiceOrderInfo['order_no'] = $no;
        $invoiceOrderInfo['price'] = $price;
        $invoiceOrderInfo['wallet_price'] = $wallet_price;
        $orderGoodsInfo = $orderGoods::with("goods")->whereIn('f_order_form_no', $no)->get()->toArray();
        foreach ($orderGoodsInfo as $k => $v) {
            $temp = explode(",", $v['f_norms_id']);
            $orderGoodsInfo[$k]["norm"] = $norms->whereIn('id', $temp)->orderBy("f_norms_group_id")->get()->toArray();
        }
        $invoiceOrderInfo['goods'] = $orderGoodsInfo;
        //1.获取用户的充值记录
        $userId = $invoiceOrderInfo['f_user_id'];
        $price1 = $recharge->where([["f_user_id", $userId], ["f_order_form_status_id", 2]])->sum("price");
        //2.获取用户没有充值记录的钱
        $price2 = $userRecharge->where("f_user_id", $userId)->select("price")->first();
        if ($price2) {
            $price2 = $price2->price;
        } else {
            $price2 = 0;
        }
        $walletPrice = ($price1 + $price2) * 100;
        //3.获取用户发票开的钱包的金额
        $invoice = $invoiceOrder->where("f_user_id", $userId)->select(DB::raw("GROUP_CONCAT(f_order_form_id) as ids"))->first();
        if ($invoice) {
            $invoice = $invoice->ids;
        } else {
            $invoice = 0;
        }
        $invoice = explode(",", $invoice);
        //dd($invoice);
        //获取订单
        $orderPrice = $order->whereIn("id", $invoice)->whereIn("f_pay_type_id", [4, 9, 10])->sum("price") * 100;
        $price = ($walletPrice - $orderPrice) / 100;
        if ($price <= 0) {
            $price = 0;
        }
        $invoiceOrderInfo['allow_price'] = $price;
        //dump($invoiceOrderInfo);
        return view("admin.invoice.info", compact('invoiceOrderInfo'));
    }

    //修改发票订单状态
    public function status($id)
    {
        $invoiceOrder = InvoiceOrder::find($id);
        $invoiceOrder->fixed_time = time();
        $invoiceOrder->is_fixed = 1;
        $invoiceOrder->save();
        return json(200, "处理成功");
    }

    //发票导出
    public function export(AddValueTax $addValueTax, InvoiceOrder $invoiceOrder, Order $order, Recharge $recharge, UserRecharge $userRecharge, Request $request, Coupon $coupon, User $user)
    {
        //获取搜索的时间
        $info["min_time"] = $request->input("min_time") ? strtotime(getTimeStamp($request->input("min_time"))) : 1420041600;
        $info["max_time"] = $request->input("max_time") ? strtotime(getTimeStamp($request->input("max_time"))) + 3600 * 24 - 1 : time();
        //获取搜索的金额
        if ($request->input("price")) {
            $info["price"] = $request->input("price");
            switch ($info["price"]) {
                case 1:
                    $min_price = 0;
                    $max_price = 1000;
                    break;
                case 2:
                    $min_price = 1000;
                    $max_price = 5000;
                    break;
                case 3:
                    $min_price = 5000;
                    $max_price = 10000;
                    break;
                case 4:
                    $min_price = 10000;
                    $max_price = 1000000;
                    break;
                default:
                    $min_price = 0;
                    $man_price = 1000000;
                    break;
            }
        } else {
            $info["price"] = 0;
            $min_price = 0;
            $max_price = 1000000;
        }
        //获取搜索的状态
        if ($request->input("status")) {
            $info["status"] = $request->input("status");
            switch ($info["status"]) {
                case 1:
                    $status = [0];
                    break;
                case 2:
                    $status = [1];
                    break;
                default:
                    $status = [0, 1];
                    break;
            }
        } else {
            $info["status"] = 0;
            $status = [0, 1];
        }
        //获取搜索的订单
        $info["no"] = $request->input("no") ? $request->input("no") : "";
        //获取公司名称用户ID
        $userId = [];
        if (!is_numeric($info["no"])) {
            $userIdS = $addValueTax->where("company_name", "like", "%{$info["no"]}%")->get()->toArray();
            foreach ($userIdS as $k => $v) {
                $userId[] = $v["f_user_id"];
            }
        }
        //获取所有员工的id (测试的员工)
        $employeeIds = $user::whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
        $employeeID = [];
        foreach ($employeeIds as $k => $v) {
            $employeeID[] = $v["id"];
        }
        //获取所有符合金额的发票id
        $ids = $invoiceOrder::all()->toArray();  //发票id
        $idz = [];
        $temp = "";
        $tempId = [];
        $tempP = [];
        foreach ($ids as $k => $v) {
            $tempId[$v["id"]] = explode(",", $v["f_order_form_id"]);  //发票id=>订单号id  数组
            $temp .= $v["f_order_form_id"] . ",";                        //订单号id  字符串
        }
        $temp = explode(",", trim($temp, ","));  //订单号id 一维数组
        //通过 支付类型 判断 折扣价 原价 (订单表)
        $priceId = $order->whereIn("id", $temp)->get()->toArray();
        foreach ($priceId as $k => $v) {
            if (in_array($v["f_pay_type_id"], [14, 15, 16])) {
                $tempP[$v["id"]] = $v["discount_price"];
            } else {
                $tempP[$v["id"]] = $v["price"];
            }
        }
//        dd($tempP);   //订单id=>价格
        //计算订单价格
        foreach ($tempId as $k => $v) {    //$tempid 发票id
            $priceSum = 0;
            foreach ($v as $kk => $vv) {   //$vv 订单id
                if (isset($tempP[$vv])) {
                    $priceSum += $tempP[$vv];
                }
            }
            $tempId[$k] = $priceSum;
        }
//        dd($tempId);   //发票id=>价格
        foreach ($tempId as $k => $v) {
            if ($v >= $min_price && $v <= $max_price) {
                $idz[] = $k;        //$idz 发票id
            }
        }
        //判断 获取数据 订单号是否存在 单位名词
        if ($info['no']) {
            if (is_numeric($info['no'])) {

                $invoiceOrderInfos = $invoiceOrder->select("id", "f_order_form_id", "receive_name", "receive_tel", "is_fixed", "invoice_type", "no")->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ['no', "like", "%{$info['no']}%"]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->orderBy('id', "desc")->get();
                $countInvoice = $invoiceOrder->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ['no', "like", "%{$info['no']}%"]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->get()->toArray();
            } else {
                $invoiceOrderInfos = $invoiceOrder->select("id", "f_order_form_id", "receive_name", "receive_tel", "is_fixed", "invoice_type", "no")->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn('f_user_id', $userId)->whereIn("id", $idz)->whereIn('is_fixed', $status)->orderBy('id', "desc")->whereIn("f_user_id", $employeeID)->get();
                $countInvoice = $invoiceOrder->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn('f_user_id', $userId)->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->get()->toArray();
            }
        } else {
            $invoiceOrderInfos = $invoiceOrder->select("id", "f_order_form_id", "receive_name", "receive_tel", "is_fixed", "invoice_type", "no")->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->orderBy('id', "desc")->whereIn("f_user_id", $employeeID)->get();
            $countInvoice = $invoiceOrder->where([["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']]])->whereIn("id", $idz)->whereIn('is_fixed', $status)->whereIn("f_user_id", $employeeID)->get()->toArray();
        }
        $priceCount = [];
        $invoiceOrderInfo = $invoiceOrderInfos->toArray();
        foreach ($invoiceOrderInfo as $k => $v) {
            $temp = explode(",", $v["f_order_form_id"]);
            //获取订单数据  优惠券
            $orderInfo = $order->whereIn("id", $temp)->get()->toArray();
            if ($orderInfo) {
                $couponNo = [];
                foreach ($orderInfo as $kk => $vv) {
                    if ($vv["f_coupon_no"]) {
                        $couponNo[] = $vv["f_coupon_no"];
                    }
                }
            } else {
                $couponNo = [];
            }
            $invoiceOrderInfo[$k]['couponPrice'] = $coupon->whereIn("no", $couponNo)->sum("use_value");
            $invoiceOrderInfo[$k]['price'] = $tempId[$v['id']];
        }
        foreach ($countInvoice as $k => $v) {
            if (in_array($v['id'], $idz)) {
                $priceCount[] = $tempId[$v['id']];
            }
        }
        $priceCount = array_sum($priceCount);
        $count = count($countInvoice);

        //整成一维数组
        $data[] = [
            "编号",
            "订单号",
            "收货人姓名",
            "收货人电话",
            "申请开票金额",
            "订单总额",
            "优惠券抵扣金额",
            "开票状态",
            "申请发票类型",
        ];
//        dd($invoiceOrderInfo);
        foreach ($invoiceOrderInfo as $k=>$v){
            $temp_invoice["id"] = $v["id"];
            $temp_invoice["no"] = $v["no"];
            $temp_invoice["receive_name"] = $v["receive_name"];
            $temp_invoice["receive_tel"] = $v["receive_tel"];
            $temp_invoice["price"] = number_format($v["price"],2,".","");
            $temp_invoice["priceSum"] = number_format($v["price"]+$v["couponPrice"],2,".","");
            $temp_invoice["couponPrice"] = number_format($v["couponPrice"],2,".","");
            if ($v["is_fixed"] == 1){
                $temp_invoice["status"] = "已处理";
            }else{
                $temp_invoice["status"] = "未处理";
            }
            $temp_invoice["invoice_type"] = $v["invoice_type"];
            $data[] = $temp_invoice;
        }
//        dd($temp_invoice);
        Excel::create("invoiceOrder",function($excel) use ($data){
           $excel->sheet("invoiceOrder",function($sheet) use ($data){
             $sheet->rows($data);
           });
        })->export("xls");

        }
    }



