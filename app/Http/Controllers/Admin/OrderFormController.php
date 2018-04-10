<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsImg;
use App\Model\Integral;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\Order;
use App\Model\OrderFormStatus;
use App\Model\OrderGoods;
use App\Model\User;
use App\Model\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderFormController extends Controller
{
    //催单列表
    public function index(Order $order,OrderFormStatus $orderFormStatus,User $user,Request $request)
    {
        //搜索分页
        $Info['status'] = $request->input('status')?$request->input('status'):0;  //催单状态
        //测试人员的id
        $userInfo = $user::select('id')->whereIn('signin_name',employeePhone())->get()->toArray();
        $userIds = [];
        foreach($userInfo as $k=>$v){
            $userIds[] = $v['id'];
        }
        //判断催单状态
        if ($Info['status']==0){
            $orderInfos = $order::with("OrderFormStatus","User")->select("id","no","create_time","is_reminder","f_order_form_status_id")->where("is_reminder",">","0")->whereNotIn("f_user_id",$userIds)->orderBy("id","desc")->paginate(15); //全部
        }elseif ($Info['status']==1){
            $Info['orders'] = array(1,3,5,6,7,9,10,11,12,13,14,15);
            $orderInfos = $order::with("OrderFormStatus")->select("id","no","create_time","is_reminder","f_order_form_status_id")->where("is_reminder",">","0")->whereIn("f_order_form_status_id",$Info['orders'])->whereNotIn("f_user_id",$userIds)->orderBy("id","desc")->paginate(15); //已处理
        }else{
            $Info['order'] = array(2,4);
            $orderInfos = $order::with("OrderFormStatus")->select("id","no","create_time","is_reminder","f_order_form_status_id")->where("is_reminder",">","0")->whereIn("f_order_form_status_id",$Info['order'])->whereNotIn("f_user_id",$userIds)->orderBy("id","desc")->paginate(15); //未处理
        }

        $orderInfo = $orderInfos->toArray();
        return view("admin.orderform.index",compact("orderInfos","orderInfo","Info","orderFormStatusInfo"));
    }

    //订单详情
    public function info(Order $order,Norms $norms,GoodsImg $goodsImg,NormsCombo $normsCombo,OrderGoods $orderGoods,$id,$status=0)
    {
        //判断前一单 后一单
        switch ($status)
        {
            case 0:
                $status="=";
                $orderInfo=$order::with("coupon", "payType", "orderFormStatus","user")->where("id","$status",$id)->where("is_reminder",">","0")->first();  //等于id时
                break;
            case 1:
                $status=">";
                $orderInfo=$order::with("coupon", "payType", "orderFormStatus","user")->where("id","$status",$id)->where("is_reminder",">","0")->orderBy("id","asc")->first(); //大于id时
                break;
            case 2:
                $status="<";
                $orderInfo=$order::with("coupon", "payType", "orderFormStatus","user")->where("id","$status",$id)->where("is_reminder",">","0")->orderBy("id","desc")->first(); //小于id时
                break;
            default:
                $status="=";
                $orderInfo=$order::with("coupon", "payType", "orderFormStatus","user")->where("id","$status",$id)->where("is_reminder",">","0")->first();
                break;
        }
        if($orderInfo){
            $orderInfo = $orderInfo->toArray();
        }else{
            return back()->with(["msg"=>"没有更多订单了"]);
        }
//        $orderInfo=$order::with("coupon", "payType", "orderFormStatus","user")->where("id","$status",$id)->where("is_reminder",">","0")->first()->toArray();
//        dd($orderInfo);
        $orderGoodsInfo=$orderGoods->where("f_order_form_no",$orderInfo['no'])->get()->toArray();
        foreach ($orderGoodsInfo as $k=>$v)
        {
            $goodsInfo[]=$normsCombo->getGoodsInfo($norms,$goodsImg,$v["f_goods_id"],$v["f_norms_id"]);
            $goodsInfo[$k]['order']=$v;
        }

        return view("admin.orderform.info",compact("id","orderInfo","goodsInfo","status","type"));
    }
    //修改订单状态
    public function status(Order $order,User $user,Integral $integral,Wallet $wallet,$no,$id)
    {
        $orderInfo=$order->where("no",$no)->first();
        if (!$orderInfo)
        {
            return json(404,"订单不存在");
        }
        //标记为已签收
        if ($orderInfo->f_order_form_status_id==5&&$id==5)
        {
            $orderInfo->f_order_form_status_id=15;
            $orderInfo->save();
            $msg="签收成功";
        }
        //标记为已送达
        if ($orderInfo->f_order_form_status_id==4&&$id==1)
        {
            $orderInfo->f_order_form_status_id=5;
            $orderInfo->save();
            $msg="标记为已送达成功";
        }
        //标记为已出库
        if ($orderInfo->f_order_form_status_id==2&&$id==2)
        {
            $orderInfo->f_order_form_status_id=4;
            $orderInfo->save();
            $msg="标记为已出库成功";
        }
        //标记为退货完成
        if ($orderInfo->f_order_form_status_id==10&&$id==3)
        {
            //扣除用户的积分
            $integrals=floor($orderInfo->price/100);
            $userInfo=$user::find($orderInfo->f_user_id);
            $userInfo->integral=$userInfo->integral-$integrals;
            $userInfo->save();
            //添加用户积分记录
            $data['f_user_id']=$orderInfo->f_user_id;
            $data['no']=$orderInfo->no;
            $data['number']="-".$integrals;
            $data['create_time']=time();
            $data['f_order_form_status_id']=2;
            $data['explain']="订单退货";
            $data['type']=0;
            $integral->create($data);
            $orderInfo->f_order_form_status_id=11;
            $orderInfo->save();
            $msg="标记为退货完成成功";
        }
        //标记为退款完成
        if ($orderInfo->f_order_form_status_id==6&&$id==4)
        {
            //扣除用户的积分
            $integrals=floor($orderInfo->price/100);
            $userInfo=$user::find($orderInfo->f_user_id);
            $userInfo->integral=$userInfo->integral-$integrals;
            if (in_array($orderInfo->f_pay_type_id,[4,9,10]))
            {
                //添加钱包和钱包记录
                $userInfo->wallet=$userInfo->wallet+$orderInfo->price;
                $info['f_user_id']=$orderInfo->f_user_id;
                $info['no']=$orderInfo->no;
                $info['number']="+".$orderInfo->price;
                $info['create_time']=time();
                $info['f_order_form_status_id']=2;
                $info['explain']="订单退款";
                $wallet->create($info);
            }
            $userInfo->save();
            //添加用户积分记录
            $data['f_user_id']=$orderInfo->f_user_id;
            $data['no']=$orderInfo->no;
            $data['number']="-".$integrals;
            $data['create_time']=time();
            $data['f_order_form_status_id']=2;
            $data['explain']="订单退货";
            $data['type']=0;
            $integral->create($data);
            $orderInfo->f_order_form_status_id=7;
            $orderInfo->save();
            $msg="标记为退款完成成功";
        }
        //标记为已出库
        if ($orderInfo->f_order_form_status_id==5&&$id==6)
        {
            $clnt=YunpianClient::create("2489d60e93f19eff2b41ee9a6da75c03");
            $param = [YunpianClient::MOBILE => "{$orderInfo->take_over_tel_no}",YunpianClient::TPL_ID=>1883542,YunpianClient::TPL_VALUE=>"#no#={$orderInfo->no}"];
            $r = $clnt->sms()->tpl_single_send($param);
            $msg="提醒用户签收成功";
        }
        //标记为已打印
        if ($id==7)
        {
            $orderInfo->print_out_time=time();
            if ($printId=$order->where([["print_out_time",">",getMonthStar()],["id","!=",$orderInfo['id']]])->orderBy("print_out_id","desc")->first()->toArray())
            {
                $orderInfo->print_out_id=$printId['print_out_id']+1;
            }else
            {
                $orderInfo->print_out_id=date("Ym")."0001";
            }
            $orderInfo->save();
            $msg="标记打印成功";
        }
        return json(200,$msg);
    }
    //打印订单
    public function printOrder(Order $order,OrderGoods $orderGoods,NormsCombo $normsCombo,Norms $norms,GoodsImg $goodsImg,$no)
    {
        //订单详情
        $orderInfo=$order::with('coupon')->where("no",$no)->first()->toArray();
        //订单商品信息
        $orderGoodsInfo=$orderGoods->where("f_order_form_no",$orderInfo['no'])->get()->toArray();
        foreach ($orderGoodsInfo as $k=>$v)
        {
            $goodsInfo[]=$normsCombo->getGoodsInfo($norms,$goodsImg,$v["f_goods_id"],$v["f_norms_id"]);
            $goodsInfo[$k]['order']=$v;
        }
        $number=0;
        foreach ($goodsInfo as $k=>$v)
        {
            $number+=$v['order']['number'];
        }
        if (in_array($orderInfo['f_pay_type_id'],[14,15,16]))
        {
            $price=number_format($orderInfo['discount_price'],2,".","");
        }else
        {
            $price=number_format($orderInfo['price'],2,".","");
        }
        $price=number2chinese($price);
        //dd($price);
        return view("admin.order.print",compact("orderInfo","goodsInfo","number","price"));
    }
}
