<?php

namespace App\Http\Controllers\Admin;

use App\Model\Area;
use App\Model\Custom;
use App\Model\Goods;
use App\Model\GoodsImg;
use App\Model\Integral;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\Order;
use App\Model\OrderFormStatus;
use App\Model\OrderGoods;
use App\Model\PayType;
use App\Model\User;
use App\Model\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yunpian\Sdk\YunpianClient;

class OrderController extends Controller
{
    //订单列表
    public function index(User $user, Order $order, OrderFormStatus $orderFormStatus, Request $request, Area $area)
    {
        //筛选条件
        $info['no'] = $request->input("no") ? $request->input("no") : "";
        $info['phone'] = $request->input("phone") ? $request->input("phone") : "";
        $userId = [];
        if ($info['phone']) {
            $userIds = $user->where("signin_name", "like", "%{$info['phone']}%")->whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        } else {
            $userIds = $user->select("id")->whereNotIn("signin_name", employeePhone())->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        }
        //dd($userId);
        if (is_array($request->input("status"))) {
            $info['status'] = $request->input("status")[0] ? $request->input("status") : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        } else {
            $info['status'] = $request->input("status") ? explode(",", $request->input("status")) : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        }
        $info["print"] = $request->input("print") ? $request->input("print") : 0;
        $info['min_time'] = $request->input("min_time") ? strtotime(getTimeStamp($request->input("min_time"))) : 1420041600;
        $info['max_time'] = $request->input("max_time") ? strtotime(getTimeStamp($request->input("max_time"))) + 3600 * 24 - 1 : time();
        $info['min_price'] = $request->input("min_price") ? number_format($request->input("min_price"), 2, ".", "") : 0;
        $info['max_price'] = $request->input("max_price") ? number_format($request->input("max_price"), 2, ".", "") : 1000000;
        $info['pay_type'] = $request->input('pay_type') ? [$request->input('pay_type')] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
        if (session("employeeInfo")["f_area_id"] == 1 && session("employeeInfo")["f_employee_type_id"] == 1) {
            $info['area'] = $request->input("area") ? $request->input("area") : 0;
        } else {
            $info['area'] = $request->input("area") ? $request->input("area") : session("employeeInfo")["f_area_id"];
        }
        $areaIds = [];
        if ($info['area']) {
            $areaInfo = $area->where("id", $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get()->toArray();
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
        } else {
            $areaIds = [0];
            $areaInfo = $area->select('id')->get()->toArray();
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
        }
        //支付方式分组
        $tempPayType1 = [];
        $tempPayType2 = [];
        foreach ($info['pay_type'] as $k => $v) {
            if (in_array($v, [14, 15, 16])) {
                $tempPayType1[] = $v;
            } else {
                $tempPayType2[] = $v;
            }
        }
        //筛选查询
        if ($info['print'] == 0) {
            $orderInfos = $order::with("coupon", "payType", "area", "orderFormStatus")->where([["no", "like", "%{$info['no']}%"], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_area_id", $areaIds)->whereIn("f_user_id", $userId)->whereIn("f_pay_type_id", $info['pay_type'])->orderBy("create_time", "desc")->paginate(15);
            $count1 = $order->where([["no", "like", "%{$info['no']}%"], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_user_id", $userId)->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_area_id", $areaIds)->whereIn("f_pay_type_id", $tempPayType1)->select(DB::raw('sum(discount_price) as total_price,count(id) as count'))->first()->toArray();
            $count2 = $order->where([["no", "like", "%{$info['no']}%"], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_user_id", $userId)->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_area_id", $areaIds)->whereIn("f_pay_type_id", $tempPayType2)->select(DB::raw('sum(price) as total_price,count(id) as count'))->first()->toArray();
        } elseif ($info['print'] == 1) {
            $orderInfos = $order::with("coupon", "payType", "area", "orderFormStatus")->where([["no", "like", "%{$info['no']}%"], ["print_out_time", ">", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<", "{$info['max_price']}"]])->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_user_id", $userId)->whereIn("f_area_id", $areaIds)->whereIn("f_pay_type_id", $info['pay_type'])->orderBy("create_time", "desc")->paginate(15);
            $count1 = $order->where([["no", "like", "%{$info['no']}%"], ["print_out_time", ">", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<", "{$info['max_price']}"]])->whereIn("f_user_id", $userId)->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_area_id", $areaIds)->whereIn("f_pay_type_id", $tempPayType1)->select(DB::raw('sum(discount_price) as total_price,count(id) as count'))->first()->toArray();
            $count2 = $order->where([["no", "like", "%{$info['no']}%"], ["print_out_time", ">", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<", "{$info['max_price']}"]])->whereIn("f_user_id", $userId)->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_area_id", $areaIds)->whereIn("f_pay_type_id", $tempPayType2)->select(DB::raw('sum(price) as total_price,count(id) as count'))->first()->toArray();
        } else {
            $orderInfos = $order::with("coupon", "payType", "area", "orderFormStatus")->where([["no", "like", "%{$info['no']}%"], ["print_out_time", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_pay_type_id", $info['pay_type'])->whereIn("f_area_id", $areaIds)->whereIn("f_user_id", $userId)->whereIn("f_order_form_status_id", $info['status'])->orderBy("create_time", "desc")->paginate(15);
            $count1 = $order->where([["no", "like", "%{$info['no']}%"], ["print_out_time", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_user_id", $userId)->whereIn("f_pay_type_id", $tempPayType1)->whereIn("f_area_id", $areaIds)->whereIn("f_order_form_status_id", $info['status'])->select(DB::raw('sum(discount_price) as total_price,count(id) as count'))->first()->toArray();
            $count2 = $order->where([["no", "like", "%{$info['no']}%"], ["print_out_time", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_user_id", $userId)->whereIn("f_pay_type_id", $tempPayType2)->whereIn("f_area_id", $areaIds)->whereIn("f_order_form_status_id", $info['status'])->select(DB::raw('sum(price) as total_price,count(id) as count'))->first()->toArray();
        }
        $count['total_price'] = $count2['total_price'] + $count1['total_price'];
        $count['count'] = $count2['count'] + $count1['count'];
        $orderInfo = $orderInfos->toArray();
        //获取订单状态列表
        $orderFormStatusInfo = $orderFormStatus::all()->toArray();
        $info['page_status'] = implode(",", $info['status']);
        $info['min_time'] = date("Y年m月d日", $info['min_time']);
        $info['max_time'] = date("Y年m月d日", $info['max_time']);
        $info['pay_type'] = count($info['pay_type']) == 1 ? $info['pay_type'][0] : 0;
        return view("admin.order.index", compact("orderInfo", "orderInfos", "orderFormStatusInfo", "info", "count"));
    }

    //订单查询
    public function search(OrderFormStatus $orderFormStatus, PayType $payType, Area $area)
    {
        if (session("employeeInfo")['f_area_id'] == 1) {
            $areaInfo = $area::all()->toArray();
        } else {
            $areaInfo = $area::where("id", session("employeeInfo")['f_area_id'])->orWhere("parent_id", session("employeeInfo")['f_area_id'])->get()->toArray();
        }
        $orderFormStatusInfo = $orderFormStatus::all()->toArray();
        $payTypeInfo = $payType::all()->toArray();
        return view("admin.order.search", compact("orderFormStatusInfo", "payTypeInfo", "areaInfo"));
    }

    //订单信息
    public function info(Order $order, Norms $norms, GoodsImg $goodsImg, NormsCombo $normsCombo, OrderGoods $orderGoods, Custom $custom,$id, $status = 0)
    {
        switch ($status) {
            case 0:
                $status = "=";
                break;
            case 1:
                $status = ">";
                break;
            case 2:
                $status = "<";
                break;
            default:
                $status = "=";
                break;
        }

        $orderInfo = $order::with("coupon", "payType", "orderFormStatus", "user")->where("id", "$status", $id)->first();

        if ($orderInfo) {
            $orderInfo = $orderInfo->toArray();
        } else {
            return back()->with(["msg" => "没有更多订单了·····"]);
        }
        $orderGoodsInfo = $orderGoods::with("custom","goods")->where("f_order_form_no", $orderInfo['no'])->get()->toArray();
        foreach ($orderGoodsInfo as $k=>$v)
        {
            $orderGoodsInfo[$k]["logo"] = "http://".$normsCombo->setCache($v['custom']["logo"]);
        }
        //dd($orderGoodsInfo);
        foreach ($orderGoodsInfo as $k => $v) {
            $temp=$normsCombo->getGoodsInfo($norms, $goodsImg, $v["f_goods_id"], $v["f_norms_id"],$orderInfo['f_area_id']);
            if (isset($temp["err"]))
            {
                $temp=$normsCombo->getGoodsInfo($norms, $goodsImg, $v["f_goods_id"], $v["f_norms_id"]);
            }
            $goodsInfo[] = $temp;
            $goodsInfo[$k]['order'] = $v;
        }
        foreach ($goodsInfo as $k => $v) {
            if (!isset($v['goods'])) {
                unset($goodsInfo[$k]);
            }
        }
        //dd($goodsInfo);
        return view("admin.order.info", compact("id", "orderInfo", "goodsInfo", "type"));
    }

    //修改订单状态
    public function status(Order $order, User $user, Integral $integral, Wallet $wallet, $no, $id)
    {
        $orderInfo = $order->where("no", $no)->first();
        if (!$orderInfo) {
            return json(404, "订单不存在");
        }
        //标记为已签收
        if ($orderInfo->f_order_form_status_id == 5 && $id == 5) {
            $orderInfo->f_order_form_status_id = 15;
            $orderInfo->save();
            $msg = "签收成功";
        }
        //标记为已送达
        if ($orderInfo->f_order_form_status_id == 4 && $id == 1) {
            $orderInfo->f_order_form_status_id = 5;
            $orderInfo->save();
            $msg = "标记为已送达成功";
        }
        //标记为已出库
        if ($orderInfo->f_order_form_status_id == 2 && $id == 2) {
            $orderInfo->f_order_form_status_id = 4;
            $orderInfo->save();
            $msg = "标记为已出库成功";
        }
        //标记为退货完成
        if ($orderInfo->f_order_form_status_id == 10 && $id == 3) {
            //扣除用户的积分
            if (in_array($orderInfo->f_pay_type_id, [14, 15, 16])) {
                $integrals = floor($orderInfo->discount_price / 100);
            } else {
                $integrals = floor($orderInfo->price / 100);
            }
            $userInfo = $user::find($orderInfo->f_user_id);
            $userInfo->integral = $userInfo->integral - $integrals;
            if (in_array($orderInfo->f_pay_type_id, [4, 9, 10])) {
                //添加钱包和钱包记录
                $userInfo->wallet = $userInfo->wallet + $orderInfo->price;
                $info['f_user_id'] = $orderInfo->f_user_id;
                $info['no'] = $orderInfo->no;
                $info['number'] = "+" . $orderInfo->price;
                $info['create_time'] = time();
                $info['f_order_form_status_id'] = 2;
                $info['explain'] = "订单退货";
                $wallet->create($info);
            }
            if (in_array($orderInfo->f_pay_type_id, [14, 15, 16])) {
                //添加钱包和钱包记录
                $userInfo->wallet = $userInfo->wallet + $orderInfo->discount_price;
                $info['f_user_id'] = $orderInfo->f_user_id;
                $info['no'] = $orderInfo->no;
                $info['number'] = "+" . $orderInfo->discount_price;
                $info['create_time'] = time();
                $info['f_order_form_status_id'] = 2;
                $info['explain'] = "订单退货";
                $wallet->create($info);
            }
            $userInfo->save();
            //添加用户积分记录
            $data['f_user_id'] = $orderInfo->f_user_id;
            $data['no'] = $orderInfo->no;
            $data['number'] = "-" . $integrals;
            $data['create_time'] = time();
            $data['f_order_form_status_id'] = 2;
            $data['explain'] = "订单退货";
            $data['type'] = 0;
            $integral->create($data);
            $orderInfo->f_order_form_status_id = 11;
            $orderInfo->save();
            $msg = "标记为退货完成成功";
        }
        //标记为退款完成
        if ($orderInfo->f_order_form_status_id == 6 && $id == 4) {
            //扣除用户的积分
            if (in_array($orderInfo->f_pay_type_id, [14, 15, 16])) {
                $integrals = floor($orderInfo->discount_price / 100);
            } else {
                $integrals = floor($orderInfo->price / 100);
            }
            $userInfo = $user::find($orderInfo->f_user_id);
            $userInfo->integral = $userInfo->integral - $integrals;
            if (in_array($orderInfo->f_pay_type_id, [4, 9, 10])) {
                //添加钱包和钱包记录
                $userInfo->wallet = $userInfo->wallet + $orderInfo->price;
                $info['f_user_id'] = $orderInfo->f_user_id;
                $info['no'] = $orderInfo->no;
                $info['number'] = "+" . $orderInfo->price;
                $info['create_time'] = time();
                $info['f_order_form_status_id'] = 2;
                $info['explain'] = "订单退款";
                $wallet->create($info);
            }
            if (in_array($orderInfo->f_pay_type_id, [14, 15, 16])) {
                //添加钱包和钱包记录
                $userInfo->wallet = $userInfo->wallet + $orderInfo->discount_price;
                $info['f_user_id'] = $orderInfo->f_user_id;
                $info['no'] = $orderInfo->no;
                $info['number'] = "+" . $orderInfo->discount_price;
                $info['create_time'] = time();
                $info['f_order_form_status_id'] = 2;
                $info['explain'] = "订单退款";
                $wallet->create($info);
            }
            $userInfo->save();
            //添加用户积分记录
            $data['f_user_id'] = $orderInfo->f_user_id;
            $data['no'] = $orderInfo->no;
            $data['number'] = "-" . $integrals;
            $data['create_time'] = time();
            $data['f_order_form_status_id'] = 2;
            $data['explain'] = "订单退货";
            $data['type'] = 0;
            $integral->create($data);
            $orderInfo->f_order_form_status_id = 7;
            $orderInfo->save();
            $msg = "标记为退款完成成功";
        }
        //标记为已出库
        if ($orderInfo->f_order_form_status_id == 5 && $id == 6) {
            $clnt = YunpianClient::create("2489d60e93f19eff2b41ee9a6da75c03");
            $param = [YunpianClient::MOBILE => "{$orderInfo->take_over_tel_no}", YunpianClient::TPL_ID => 1883542, YunpianClient::TPL_VALUE => "#no#={$orderInfo->no}"];
            $r = $clnt->sms()->tpl_single_send($param);
            $msg = "提醒用户签收成功";
        }
        //标记为已打印
        if ($id == 7) {
            $orderInfo->print_out_time = time();
            if ($printId = $order->where([["print_out_time", ">", getMonthStar()], ["id", "!=", $orderInfo['id']]])->orderBy("print_out_id", "desc")->first()) {
                $orderInfo->print_out_id = $printId['print_out_id'] + 1;
            } else {
                $orderInfo->print_out_id = date("Ym") . "0001";
            }
            $orderInfo->save();
            $msg = "标记打印成功";
        }
        //退款驳回
        if ($orderInfo->f_order_form_status_id == 6 && $id == 8) {
            $orderInfo->f_order_form_status_id = 4;
            $orderInfo->save();
            $msg = "退款驳回成功";
        }
        return json(200, $msg);
    }

    //打印订单
    public function printOrder(Order $order, OrderGoods $orderGoods, NormsCombo $normsCombo, Norms $norms, GoodsImg $goodsImg, $no)
    {
        //订单详情
        $orderInfo = $order::with('coupon')->where("no", $no)->first()->toArray();
        //订单商品信息
        $orderGoodsInfo = $orderGoods->where("f_order_form_no", $orderInfo['no'])->get()->toArray();
        foreach ($orderGoodsInfo as $k => $v) {
            $temp=$normsCombo->getGoodsInfo($norms, $goodsImg, $v["f_goods_id"], $v["f_norms_id"],$orderInfo['f_area_id']);
            if (isset($temp["err"]))
            {
                $temp=$normsCombo->getGoodsInfo($norms, $goodsImg, $v["f_goods_id"], $v["f_norms_id"]);
            }
            $goodsInfo[] = $temp;
            $goodsInfo[$k]['order'] = $v;
        }
        $number = 0;
        foreach ($goodsInfo as $k => $v) {
            $number += $v['order']['number'];
        }
        if (in_array($orderInfo['f_pay_type_id'], [14, 15, 16])) {
            $price = number_format($orderInfo['discount_price'], 2, ".", "");
        } else {
            $price = number_format($orderInfo['price'], 2, ".", "");
        }
        $price2 = $price - $orderInfo['virtual_discount'];
        $price = number2chinese($price2);
        //dd($price);
        return view("admin.order.print", compact("orderInfo", "goodsInfo", "number", "price", 'price2'));
    }

    //添加订单备注
    public function remark(Order $order, Request $request, $id)
    {
        $orderInfo = $order::find($id);
        $orderInfo->employee_remark = $request->input("name");
        $orderInfo->save();
        return json(200, "添加备注成功");
    }

    //订单导出
    public function export(User $user, Order $order, OrderFormStatus $orderFormStatus, Request $request, Area $area,PayType $payType)
    {
        if ($request->isMethod("get"))
        {
            if (session("employeeInfo")['f_area_id'] == 1) {
                $areaInfo = $area::all()->toArray();
            } else {
                $areaInfo = $area::where("id", session("employeeInfo")['f_area_id'])->orWhere("parent_id", session("employeeInfo")['f_area_id'])->get()->toArray();
            }
            $orderFormStatusInfo = $orderFormStatus::all()->toArray();
            $payTypeInfo = $payType::all()->toArray();
            return view("admin.order.export", compact("orderFormStatusInfo", "payTypeInfo", "areaInfo"));
        }
        //筛选条件
        $info['no'] = $request->input("no") ? $request->input("no") : "";
        $info['phone'] = $request->input("phone") ? $request->input("phone") : "";
        $userId = [];
        if ($info['phone']) {
            $userIds = $user->where("signin_name", "like", "%{$info['phone']}%")->whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        } else {
            $userIds = $user->select("id")->whereNotIn("signin_name", employeePhone())->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        }
        //dd($userId);
        if (is_array($request->input("status"))) {
            $info['status'] = $request->input("status")[0] ? $request->input("status") : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        } else {
            $info['status'] = $request->input("status") ? explode(",", $request->input("status")) : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        }
        $info["print"] = $request->input("print") ? $request->input("print") : 0;
        $info['min_time'] = $request->input("min_time") ? strtotime(getTimeStamp($request->input("min_time"))) : 1420041600;
        $info['max_time'] = $request->input("max_time") ? strtotime(getTimeStamp($request->input("max_time"))) + 3600 * 24 - 1 : time();
        $info['min_price'] = $request->input("min_price") ? number_format($request->input("min_price"), 2, ".", "") : 0;
        $info['max_price'] = $request->input("max_price") ? number_format($request->input("max_price"), 2, ".", "") : 1000000;
        $info['pay_type'] = $request->input('pay_type') ? [$request->input('pay_type')] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
        if (session("employeeInfo")["f_area_id"] == 1 && session("employeeInfo")["f_employee_type_id"] == 1) {
            $info['area'] = $request->input("area") ? $request->input("area") : 0;
        } else {
            $info['area'] = $request->input("area") ? $request->input("area") : session("employeeInfo")["f_area_id"];
        }
        $areaIds = [];
        if ($info['area']) {
            $areaInfo = $area->where("id", $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get()->toArray();
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
        } else {
            $areaIds = [0];
            $areaInfo = $area->select('id')->get()->toArray();
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
        }
        //支付方式分组
        foreach ($info['pay_type'] as $k=>$v)
        {
            if (in_array($v,[14,15,16]))
            {
                $tempPayType1[]=$v;
            }else
            {
                $tempPayType2[]=$v;
            }
        }
        //筛选查询
        if ($info['print'] == 0) {
            $orderInfo = $order::with("coupon", "payType", "area", "orderFormStatus","user")->where([["no", "like", "%{$info['no']}%"], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_area_id", $areaIds)->whereIn("f_user_id", $userId)->whereIn("f_pay_type_id", $info['pay_type'])->orderBy("create_time", "desc")->get()->toArray();
        } elseif ($info['print'] == 1) {
            $orderInfo = $order::with("coupon", "payType", "area", "orderFormStatus","user")->where([["no", "like", "%{$info['no']}%"], ["print_out_time", ">", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<", "{$info['max_price']}"]])->whereIn("f_order_form_status_id", $info['status'])->whereIn("f_user_id", $userId)->whereIn("f_area_id", $areaIds)->whereIn("f_pay_type_id", $info['pay_type'])->orderBy("create_time", "desc")->get()->toArray();
        } else {
            $orderInfo = $order::with("coupon", "payType", "area", "orderFormStatus","user")->where([["no", "like", "%{$info['no']}%"], ["print_out_time", 0], ["create_time", ">=", $info['min_time']], ["create_time", "<=", $info['max_time']], ["price", ">=", "{$info['min_price']}"], ["price", "<=", "{$info['max_price']}"]])->whereIn("f_pay_type_id", $info['pay_type'])->whereIn("f_area_id", $areaIds)->whereIn("f_user_id", $userId)->whereIn("f_order_form_status_id", $info['status'])->orderBy("create_time", "desc")->get()->toArray();
        }
        $data[]=[
            "订单号",
            "订单价格",
            "公司",
            "收货地址",
            "收货人",
            "收货电话",
            "用户手机",
            "用户名",
            "地区",
            "订单状态",
            "支付方式",
            "优惠券",
            "支付时间",
            "创建时间"
            ];
        //整理财务需要的数据
        foreach ($orderInfo as $k=>$v)
        {
            $temp['no']=$v['no']."|";
            if (in_array($v['f_pay_type_id'],[14,15,16]))
            {
                $temp['price']=$v['discount_price'];
            }else
                {
                    $temp['price']=$v['price'];
                }
            $temp['take_over_company']=$v['take_over_company'];
            $temp['take_over_addr']=$v['take_over_addr'];
            $temp['take_over_name']=$v['take_over_name'];
            $temp['take_over_tel_no']=$v['take_over_tel_no'];
            $temp['signin_name']=$v['user']['signin_name'];
            $temp['username']=$v['user']['username'];
            $temp['area']=$v['area']['name'];
            $temp['order_form_status']=$v['order_form_status']['name'];
            $temp['pay_type']=$v['pay_type']['name'];
            $temp['coupon']=$v['coupon']?number_format($v["coupon"]['use_value'],2,".",""):"未使用优惠券";
            $temp['pay_time']=date("Y-m-d H:i:s",$v['pay_time']);
            $temp['create_time']=date("Y-m-d H:i:s",$v['create_time']);
            $data[]=$temp;
        }
        Excel::create('order',function($excel) use ($data){
            $excel->sheet('order', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }
}
