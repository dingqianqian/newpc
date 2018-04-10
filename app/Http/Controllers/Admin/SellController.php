<?php

namespace App\Http\Controllers\Admin;

use App\Model\Area;
use App\Model\CheckIns;
use App\Model\Employee;
use App\Model\Order;
use App\Model\Recharge;
use App\Model\User;
use App\Model\UserRecharge;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SellController extends Controller
{
    //用户注册量的查看
    public function register(Request $request, User $user, Area $area, Employee $employee)
    {
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time'))) +3600*24-1: time();
        $info['area'] = $request->input("area") ? $request->input("area") : 0;
        $info['employee'] = $request->input("employee") ? $request->input("employee") : 0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area']) {
            $areaId = Area::where('id', $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get();
            $areaIds = [];
            foreach ($areaId as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeId = $employee::where("f_department_id", 2)->whereIn('f_area_id', $areaIds)->select("id")->get()->toArray();
            $employeeIds = [];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        } else {
            $employeeId = $employee::where("f_department_id", 2)->select("id")->get()->toArray();
            $employeeIds = [0];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        }
        if ($info['employee']) {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']]])->orderBy("id","desc")->paginate(15);
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']]])->count();
        } else {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']]])->whereIn("f_employee_id", $employeeIds)->orderBy("id","desc")->paginate(15);
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']]])->whereIn("f_employee_id", $employeeIds)->count();
        }

        $userInfo = $userInfos->toArray();
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();
            //获取所有销售员工
            $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
            $areaIds = [];
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeInfo=$employee::where("f_department_id", 2)->whereIn("f_area_id",$areaIds)->get()->toArray();
        }
        $info['start_time'] = date("Y年m月d日", $info['start_time']);
        $info['end_time'] = date("Y年m月d日", $info['end_time']);
        return view("admin.sell.register", compact("userInfos", "userInfo", "areaInfo", "employeeInfo", "info", "count"));
    }

    //成交用户
    public function money(Request $request, User $user, Area $area, Employee $employee, Order $order)
    {
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time')))+3600*24-1: time();
        $info['area'] = $request->input("area") ? $request->input("area") : 0;
        $info['employee'] = $request->input("employee") ? $request->input("employee") : 0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        //查询所有的员工
        $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();
        if ($info['employee']) {
            $employeeId[] = [$info['employee']];
        } else {
            if ($info['area']) {
                $areaId = Area::where('id', $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get();
                $areaIds = [];
                foreach ($areaId as $k => $v) {
                    $areaIds[] = $v['id'];
                }
                $employeeIds = $employee::where("f_department_id", 2)->whereIn('f_area_id', $areaIds)->select("id")->get()->toArray();
                $employeeId = [];
                foreach ($employeeIds as $k => $v) {
                    $employeeId[] = $v['id'];
                }
            } else {
                $employeeId = [];
                foreach ($employeeInfo as $k => $v) {
                    $employeeId[] = $v["id"];
                }
            }
        }
        //查询所有有消费的用户
        $userIds = $user::with("employee")->whereIn("f_employee_id", $employeeId)->get()->toArray();
        $userId = [];
        $count = 0;
        foreach ($userIds as $k => $v) {
                $userId[] = $v["id"];
        }
        $userPrice=$user::with(["order"=>function($query) use ($info){
            $query->where([["create_time",">=",$info["start_time"]],["create_time","<=",$info["end_time"]]]);
            $query->whereIn("f_order_form_status_id",[2,4,5,14,15]);
        }])->whereIn("id",$userId)->get()->toArray();
        $userIdz=[];
        foreach ($userPrice as $k=>$v)
        {
            foreach ($v['order'] as $k1=>$v1)
            {
                if ($v1['create_time']>=$v['bind_employee_time']&&$v1['create_time']>=$info['start_time']&&$v1['create_time']<=$info['end_time'])
                {
                    $userIdz[]=$v1["f_user_id"];
                    if (in_array($v1['f_pay_type_id'],[14,15,16]))
                    {
                        $count+=$v1['discount_price'];
                    }else
                        {
                            $count+=$v1['price'];
                        }
                }
            }
        }
        //查询所有用户
        $userInfos = $user::with("employee")->whereIn("f_employee_id", $employeeId)->whereIn("id", $userIdz)->paginate(15);
        $userInfo = $userInfos->toArray();
        foreach ($userInfo['data'] as $k => $v) {
            $price = $order->where([["create_time", ">", $v['bind_employee_time']], ["create_time", ">=", $info['start_time']], ["create_time", "<=", $info['end_time']], ["f_user_id", $v['id']]])->whereIn("f_order_form_status_id", [2, 4, 5, 14, 15])->sum("price");
            $userInfo['data'][$k]['price'] = $price;
        }
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();
            //获取所有销售员工
            $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
            $areaIds = [];
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeInfo=$employee::where("f_department_id", 2)->whereIn("f_area_id",$areaIds)->get()->toArray();
        }
        $info['start_time'] = date("Y年m月d日", $info['start_time']);
        $info['end_time'] = date("Y年m月d日", $info['end_time']);
        return view("admin.sell.money", compact("employeeInfo", "userInfo", "userInfos", "count", "info", "areaInfo"));
    }

    //用户改绑
    public function change(Request $request, User $user, Area $area, Employee $employee)
    {
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time')))+3600*24-1: time();
        $info['area'] = $request->input("area") ? $request->input("area") : 0;
        $info['employee'] = $request->input("employee") ? $request->input("employee") : 0;
        $info['signin_name'] = $request->input('signin_name')?$request->input('signin_name'):"";//账户
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area']) {
            $areaId = Area::where('id', $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get();
            $areaIds = [];
            foreach ($areaId as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeId = $employee::where("f_department_id", 2)->whereIn('f_area_id', $areaIds)->select("id")->get()->toArray();
            $employeeIds = [];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        } else {
            $employeeId = $employee::where("f_department_id", 2)->select("id")->get()->toArray();
            $employeeIds = [0];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        }
        if ($info['employee']) {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']],["signin_name","like","%{$info["signin_name"]}%"]])->whereNotIn("signin_name",employeePhone())->paginate(15);
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']]])->count();
        } else {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']],["signin_name","like","%{$info["signin_name"]}%"]])->whereIn("f_employee_id", $employeeIds)->whereNotIn("signin_name",employeePhone())->paginate(15);
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']]])->whereIn("f_employee_id", $employeeIds)->count();
        }

        $userInfo = $userInfos->toArray();
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();
            //获取所有销售员工
            $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
            $areaIds = [];
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeInfo=$employee::where("f_department_id", 2)->whereIn("f_area_id",$areaIds)->get()->toArray();
        }
        $info['start_time'] = date("Y年m月d日", $info['start_time']);
        $info['end_time'] = date("Y年m月d日", $info['end_time']);
        return view("admin.sell.change",compact("userInfos", "userInfo", "areaInfo", "employeeInfo", "info", "count"));
    }

    //会员详情
    public function info(User $user,Recharge $recharge,UserRecharge $userRecharge,CheckIns $checkIns,Order $order,$id,$type)
    {
        $userInfo=$user::with("employee")->find($id)->toArray();
        //获取充值金额
        $userInfo['recharge_price']=$recharge->where([["f_user_id",$id],['f_order_form_status_id',2]])->sum("price");
        $userInfo['recharge_price']+=$userRecharge->where("f_user_id",$id)->sum("price");
        //返现金额
        $userInfo['give_back']=$recharge->where([["f_user_id",$id],['f_order_form_status_id',2]])->sum("give_back");
        $userInfo['give_back']+=$userRecharge->where("f_user_id",$id)->sum("give");
        //签到金额
        $userInfo['check_price']=$checkIns->where("f_user_id",$id)->sum("price");
        //订单消费金额
        $userInfo['order_price']=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->sum("price");
        //钱包支付总金额
        $userInfo['wallet_price']=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn('f_pay_type_id',[4,9,10])->sum("price");
        //微信支付总金额
        $userInfo['weixin_price']=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn('f_pay_type_id',[2,5,7])->sum("price");
        //支付宝支付总净额
        $userInfo['ali_price']=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn('f_pay_type_id',[1,6,8])->sum("price");
        return view("admin.sell.info",compact("userInfo","type"));
    }

    //员工查看本人的注册量
    public function personRegister(Request $request, User $user, Area $area, Employee $employee)
    {
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time'))) +3600*24-1: time();
        $id=session("employeeInfo")['id'];
        //$id=15;
        $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']],["f_employee_id",$id]])->paginate(15);
        $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']],["f_employee_id",$id]])->count();
        $userInfo=$userInfos->toArray();
        $info['start_time'] = date("Y年m月d日", $info['start_time']);
        $info['end_time'] = date("Y年m月d日", $info['end_time']);
        //获取所有地区
        $areaInfo = $area::all()->toArray();
        return view("admin.sell.personRegister",compact("userInfos", "userInfo", "info", "count","areaInfo"));
    }
    //员工查看本人的成交量
    public function personMoney(Request $request, User $user, Area $area, Employee $employee, Order $order)
    {
        $id=session("employeeInfo")['id'];
        //$id=15;
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time')))+3600*24-1: time();
        //查询所有有消费的用户
        $userIds = $user::with("employee")->where("f_employee_id", $id)->get()->toArray();
        $userId = [];
        $count = 0;
        foreach ($userIds as $k => $v) {
            $userId[] = $v["id"];
        }
        $userPrice=$user::with(["order"=>function($query) use ($info){
            $query->where([["create_time",">=",$info["start_time"]],["create_time","<=",$info["end_time"]]]);
            $query->whereIn("f_order_form_status_id",[2,4,5,14,15]);
        }])->whereIn("id",$userId)->get()->toArray();
        $userIdz=[];
        foreach ($userPrice as $k=>$v)
        {
            foreach ($v['order'] as $k1=>$v1)
            {
                if ($v1['create_time']>=$v['bind_employee_time']&&$v1['create_time']>=$info['start_time']&&$v1['create_time']<=$info['end_time'])
                {
                    $userIdz[]=$v1["f_user_id"];
                    $count+=$v1['price'];
                }
            }
        }
        //查询所有用户
        $userInfos = $user::with("employee")->where("f_employee_id", $id)->whereIn("id", $userIdz)->paginate(15);
        $userInfo = $userInfos->toArray();
        foreach ($userInfo['data'] as $k => $v) {
            $price = $order->where([["create_time", ">", $v['bind_employee_time']], ["create_time", ">=", $info['start_time']], ["create_time", "<=", $info['end_time']], ["f_user_id", $v['id']]])->whereIn("f_order_form_status_id", [2, 4, 5, 14, 15])->sum("price");
            $userInfo['data'][$k]['price'] = $price;
        }
        //获取所有地区
        $areaInfo = $area::all()->toArray();
        $info['start_time'] = date("Y年m月d日", $info['start_time']);
        $info['end_time'] = date("Y年m月d日", $info['end_time']);
        return view("admin.sell.personMoney", compact("employeeInfo", "userInfo", "userInfos", "count", "info", "areaInfo"));
    }

    //用户改绑ajax
    public function changeEmployee(Request $request,User $user,$id)
    {
        $userInfo=$user::find($id);
        $userInfo->f_employee_id=$request->input("employee");
        $userInfo->bind_employee_time=time();
        $userInfo->save();
        return json(200,"修改成功");
    }

    //注册图表
    public function registerChart(Area $area,User $user,Request $request,Employee $employee)
    {
        $info['min_time']=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info['max_time']=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['area']=$request->input("area")?$request->input("area"):0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area'])
        {
            $areaIds=$area->where("id",$info['area'])->orWhere("parent_id",$info['area'])->get()->toArray();
            foreach ($areaIds as $k=>$v)
            {
                $areaId[]=$v['id'];
            }
        }else
            {
                $areaIds=$area->get()->toArray();
                foreach ($areaIds as $k=>$v)
                {
                    $areaId[]=$v['id'];
                }
            }
        $orderBys=$user->select(DB::raw("f_employee_id,count(*) as count"))->where([["bind_employee_time",">=",$info['min_time']],["bind_employee_time","<=",$info['max_time']]])->whereNotIn("f_employee_id",[0,1,70])->groupBy("f_employee_id")->orderBy("count","desc")->get()->toArray();
        $orderBy=[];
        foreach ($orderBys as $k=>$v)
        {
            $orderBy[]=$v["f_employee_id"];
        }
        $employeeId=$employee::where("f_department_id",2)->whereNotIn("id",[0,1,70])->select(DB::raw("GROUP_CONCAT(id) as ids"))->first()->toArray();
        $employeeId=explode(",",$employeeId["ids"]);
        foreach ($employeeId as $k=>$v)
        {
            if (!in_array($v,$orderBy))
            {
                $orderBy[]=$v;
            }
        }
        $orderByz=implode(",",$orderBy);
        $page=$request->input("page")?$request->input("page"):1;
        $employeeInfos=$employee::with(["user"=>function($query) use ($info)
        {
            $query->where([["bind_employee_time",">=",$info['min_time']],["bind_employee_time","<=",$info['max_time']]]);
        }])->whereIn("id",$orderBy)->whereIn("f_area_id",$areaId)->orderByRaw(DB::raw("FIELD(id,$orderByz)"))->paginate(15);
        $employeeInfo=$employeeInfos->toArray();
        //获取所有的地区
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
        }
        $info['min_time']=date("Y年m月d日",$info['min_time']);
        $info['max_time']=date("Y年m月d日",$info['max_time']);
        return view("admin.sell.registerChart",compact("employeeInfo","employeeInfos","page","areaInfo","info"));
    }

    //单个用户图表
    public function personRegisterChart(Request $request,User $user,Employee $employee,$id)
    {
        $info['time']=$request->input("time")?strtotime(getTimeStamp($request->input("time"))):strtotime(date("Y-m-d 0:0:0",strtotime("-30 days")));
        $userInfo=$user::where([["f_employee_id",$id],["bind_employee_time",">=",$info["time"]]])->select(DB::raw("FROM_UNIXTIME(bind_employee_time,'%Y-%m-%d') as dates,count(*) as count"))->groupBy("dates")->limit(30)->get()->toArray();
        for ($i=0;$i<30;$i++)
        {
            $date[]=date("Y-m-d",$info['time']+3600*24*$i);
        }
        foreach ($userInfo as $k=>$v)
        {
            $temp[$v['dates']]=$v;
        }
        foreach ($date as $k=>$v)
        {
            if (!isset($temp[$v]))
            {
                $data['dates']=$v;
                $data['count']=0;
                $registerInfo[$v]=$data;
            }else
                {
                    $registerInfo[$v]=$temp[$v];
                }
        }
        //获取单个销售员工最近一个月的注册量
        $info['time']=date("Y年m月d日",$info['time']);
        $employeeInfo=$employee::find($id)->toArray();
        foreach ($registerInfo as $k=>$v)
        {
            $registerInfos[$v['dates']]=$v['count'];
        }
        return view("admin.sell.personRegisterChart",compact("registerInfos","info","id","employeeInfo"));
    }

    //成交图表
    public function moneyChart(Area $area,Employee $employee,User $user,Request $request)
    {
        $info['min_time']=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info['max_time']=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['area']=$request->input("area")?$request->input("area"):0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area'])
        {
            $areaIds=$area->where("id",$info['area'])->orWhere("parent_id",$info['area'])->get()->toArray();
            foreach ($areaIds as $k=>$v)
            {
                $areaId[]=$v['id'];
            }
        }else
        {
            $areaIds=$area->get()->toArray();
            foreach ($areaIds as $k=>$v)
            {
                $areaId[]=$v['id'];
            }
        }
        //用户表
        $orderInfo=$user::with(["order"=>function($query) use($info)
        {
            $query->where([["create_time",">=",$info["min_time"]],["create_time","<=",$info["max_time"]]]);
            $query->whereIn("f_order_form_status_id",[2,4,5,14,15]);
        }])->whereNotIn("f_employee_id",[0,1,70])->get()->groupBy("f_employee_id")->toArray();

        //计算员工订单成交额
        foreach ($orderInfo as $k=>$v)
        {
            $temp=0;
            foreach ($v as $k1=>$v1)
            {
                foreach ($v1['order'] as $k2=>$v2)
                {
                    if ($v1['bind_employee_time']<$v2['create_time'])
                    {
                        if (in_array($v2['f_pay_type_id'],[14,15,16]))
                        {
                            $temp+=intval($v2['discount_price']*100);
                        }else
                            {
                                $temp+=intval($v2['price']*100);
                            }
                    }
                }
            }
            $price[$k]=$temp;
        }
        arsort($price);
        foreach ($price as $k=>$v)
        {
            $orderBy[]=$k;
        }
        $employeeId=$employee::where("f_department_id",2)->whereNotIn("id",[0,1,70])->select(DB::raw("GROUP_CONCAT(id) as ids"))->first()->toArray();
        $employeeId=explode(",",$employeeId["ids"]);
        foreach ($employeeId as $k=>$v)
        {
            if (!in_array($v,$orderBy))
            {
                $orderBy[]=$v;
                $price[$v]=0;
            }
        }
        $orderByz=implode(",",$orderBy);
        $employeeInfos=$employee::with(["user"=>function($query) use ($info)
        {
            $query->where([["bind_employee_time",">=",$info['min_time']],["bind_employee_time","<=",$info['max_time']]]);
        }])->whereIn("id",$orderBy)->whereIn("f_area_id",$areaId)->orderByRaw(DB::raw("FIELD(id,$orderByz)"))->paginate(15);
        $employeeInfo=$employeeInfos->toArray();
        $page=$request->input("page")?$request->input("page"):1;
        //获取所有的地区
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
        }
        $info['min_time']=date("Y年m月d日",$info['min_time']);
        $info['max_time']=date("Y年m月d日",$info['max_time']);
        return view("admin.sell.moneyChart",compact("employeeInfos","employeeInfo","price","page","areaInfo","info"));
    }

    //单个员工成交图表
    public function personMoneyChart(Request $request,User $user,Employee $employee,$id)
    {
        $info['time']=$request->input("time")?strtotime(getTimeStamp($request->input("time"))):strtotime(date("Y-m-d 0:0:0",strtotime("-30 days")));
        $userInfo=$user::with(["order"=>function($query) use($info)
        {
            $query->whereIn("f_order_form_status_id",[2,4,5,14,15]);
        }])->where("f_employee_id",$id)->get()->toArray();

        for ($i=0;$i<30;$i++)
        {
            $dates[]=date("Y-m-d",$info['time']+3600*24*$i);
        }
        $temp=[];
        foreach ($userInfo as $k=>$v)
        {
            foreach ($v['order'] as $k1=>$v1)
            {
                if ($v1['create_time']>$v['bind_employee_time'] && $v1['create_time']<=$info['time']+3600*24*30)
                {
                    $temp[]=$v1;
                }
            }
        }
        $price=[];
        foreach ($temp as $k=>$v)
        {
            $date=date("Y-m-d",$v['create_time']);
            if (in_array($v['f_pay_type_id'],[14,15,16]))
            {
                $price[$date][]=$v["discount_price"];
            }else
                {
                    $price[$date][]=$v["price"];
                }
        }
        foreach ($price as $k=>$v)
        {
            $price[$k]=array_sum($v);
        }

        foreach ($dates as $k=>$v)
        {
            if (!isset($price[$v]))
            {
                $moneyInfo[$v]=0;
            }else
            {
                $moneyInfo[$v]=$price[$v];
            }
        }
        $info['time']=date("Y年m月d日",$info['time']);
        $employeeInfo=$employee::find($id)->toArray();
        //获取员工的
        return view("admin.sell.personMoneyChart",compact("id","moneyInfo","info","employeeInfo"));
    }

    //注册用户导出
    public function registerExport(Request $request,User $user,Area $area,Employee $employee)
    {
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time'))) +3600*24-1: time();
        $info['area'] = $request->input("area") ? $request->input("area") : 0;
        $info['employee'] = $request->input("employee") ? $request->input("employee") : 0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area']) {
            $areaId = Area::where('id', $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get();
            $areaIds = [];
            foreach ($areaId as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeId = $employee::where("f_department_id", 2)->whereIn('f_area_id', $areaIds)->select("id")->get()->toArray();
            $employeeIds = [];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        } else {
            $employeeId = $employee::where("f_department_id", 2)->select("id")->get()->toArray();
            $employeeIds = [0];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        }
        if ($info['employee']) {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']]])->orderBy("id","desc")->get();
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']]])->count();
        } else {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']]])->whereIn("f_employee_id", $employeeIds)->orderBy("id","desc")->get();
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']]])->whereIn("f_employee_id", $employeeIds)->count();
        }

        $userInfo = $userInfos->toArray();

        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();
            //获取所有销售员工
            $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
            $areaIds = [];
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeInfo=$employee::where("f_department_id", 2)->whereIn("f_area_id",$areaIds)->get()->toArray();
        }
//        dd($userInfo);
        //整成一维数组
        $data[] = [
            '编号',
            '账户',
            '用户名',
            '酒店名称',
            '所在地区',
            '注册时间',
            '绑定时间',
            '绑定所属员工',
        ];
        foreach($userInfo as $k=>$v){
            $temp_user["id"] = $v["id"];
            $temp_user["signin_name"] = $v["signin_name"];
            $temp_user["username"] = $v["username"]?$v["username"]:"未绑定";
            $temp_user["hotel_name"] = $v['hotel_name']?$v['hotel_name']:"未填写";
            if ($v['employee']['f_area_id']==0){
                $temp_user["area"] = "未绑定";
            }else{
                foreach($areaInfo as $kk=>$vv){
                    if ($v["employee"]["f_area_id"] == $vv["id"]){
                        $temp_user["area"] = $vv["name"];
                    }
                }
            }
            $temp_user["create_time"] = date("Y-m-d H:i:s",$v["create_time"]);
            $temp_user["bind_employee_time"] = date("Y-m-d H:i:s",$v["bind_employee_time"]);
            $temp_user["employee"] = $v['employee']?$v['employee']['username']:"未绑定";
            $data[] = $temp_user;
        }
        Excel::create('register',function($excel) use ($data){
            $excel->sheet('register', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');

    }

    //成交用户导出
    public function moneyExport(Request $request, User $user, Area $area, Employee $employee, Order $order)
    {
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time')))+3600*24-1: time();
        $info['area'] = $request->input("area") ? $request->input("area") : 0;
        $info['employee'] = $request->input("employee") ? $request->input("employee") : 0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        //查询所有的员工
        $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();
        if ($info['employee']) {
            $employeeId[] = [$info['employee']];
        } else {
            if ($info['area']) {
                $areaId = Area::where('id', $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get();
                $areaIds = [];
                foreach ($areaId as $k => $v) {
                    $areaIds[] = $v['id'];
                }
                $employeeIds = $employee::where("f_department_id", 2)->whereIn('f_area_id', $areaIds)->select("id")->get()->toArray();
                $employeeId = [];
                foreach ($employeeIds as $k => $v) {
                    $employeeId[] = $v['id'];
                }
            } else {
                $employeeId = [];
                foreach ($employeeInfo as $k => $v) {
                    $employeeId[] = $v["id"];
                }
            }
        }
        //查询所有有消费的用户
        $userIds = $user::with("employee")->whereIn("f_employee_id", $employeeId)->get()->toArray();
        $userId = [];
        $count = 0;
        foreach ($userIds as $k => $v) {
            $userId[] = $v["id"];
        }
        $userPrice=$user::with(["order"=>function($query) use ($info){
            $query->where([["create_time",">=",$info["start_time"]],["create_time","<=",$info["end_time"]]]);
            $query->whereIn("f_order_form_status_id",[2,4,5,14,15]);
        }])->whereIn("id",$userId)->get()->toArray();
        $userIdz=[];
        foreach ($userPrice as $k=>$v)
        {
            foreach ($v['order'] as $k1=>$v1)
            {
                if ($v1['create_time']>=$v['bind_employee_time']&&$v1['create_time']>=$info['start_time']&&$v1['create_time']<=$info['end_time'])
                {
                    $userIdz[]=$v1["f_user_id"];
                    if (in_array($v1['f_pay_type_id'],[14,15,16]))
                    {
                        $count+=$v1['discount_price'];
                    }else
                    {
                        $count+=$v1['price'];
                    }
                }
            }
        }
        //查询所有用户
        $userInfos = $user::with("employee")->whereIn("f_employee_id", $employeeId)->whereIn("id", $userIdz)->get();
        $userInfo = $userInfos->toArray();
        foreach ($userInfo as $k => $v) {
            $price = $order->where([["create_time", ">", $v['bind_employee_time']], ["create_time", ">=", $info['start_time']], ["create_time", "<=", $info['end_time']], ["f_user_id", $v['id']]])->whereIn("f_order_form_status_id", [2, 4, 5, 14, 15])->sum("price");
            $userInfo[$k]['price'] = $price;
        }
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();
            //获取所有销售员工
            $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
            $areaIds = [];
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeInfo=$employee::where("f_department_id", 2)->whereIn("f_area_id",$areaIds)->get()->toArray();
        }
      //整成一维数组
        $data[] = [
            '编号',
            '账户',
            '用户名',
            '酒店名称',
            '所在地区',
            '成交金额',
            '注册时间',
            '绑定时间',
            '绑定时所属员工',
        ];
//                dd($userInfo);
        foreach($userInfo as $k=>$v){
            $temp_money["id"] = $v["id"];
            $temp_money["signin_name"] = $v["signin_name"];
            $temp_money["username"] = $v['username']?$v['username']:"未填写";
            $temp_money["hotel_name"] = $v["hotel_name"]?$v["hotel_name"]:"未填写";
            if($v["employee"]["f_area_id"] == 0){
                $temp_money["area"] = "未绑定";
            }else{
                foreach($areaInfo as $kk=>$vv){
                if ($v["employee"]["f_area_id"] == $vv["id"]){
                    $temp_money["area"] = $vv["name"];
                }
             }
            }
            $temp_money["price"] = number_format($v["price"],2,".","");
            $temp_money["create_time"] = date("Y-m-d H:i:s",$v['create_time']);
            $temp_money["bind_employee_time"] = $v['bind_employee_time']?date("Y-m-d H:i:s",$v['bind_employee_time']):"未绑定";
            $temp_money["employee"] = $v['employee']?$v['employee']['username']:"未绑定";
            $data[] = $temp_money;
        }
        Excel::create("money",function ($excel) use ($data){
            $excel->sheet('money',function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }

    //用户改绑导出
    public function changeExport(Request $request, User $user, Area $area, Employee $employee)
    {
        $info['start_time'] = $request->input('start_time') ? strtotime(getTimeStamp($request->input('start_time'))) : 1420041600;
        $info['end_time'] = $request->input('end_time') ? strtotime(getTimeStamp($request->input('end_time')))+3600*24-1: time();
        $info['area'] = $request->input("area") ? $request->input("area") : 0;
        $info['employee'] = $request->input("employee") ? $request->input("employee") : 0;
        $info['signin_name'] = $request->input('signin_name')?$request->input('signin_name'):"";//账户
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area']) {
            $areaId = Area::where('id', $info['area'])->orWhere("parent_id", $info['area'])->select('id')->get();
            $areaIds = [];
            foreach ($areaId as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeId = $employee::where("f_department_id", 2)->whereIn('f_area_id', $areaIds)->select("id")->get()->toArray();
            $employeeIds = [];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        } else {
            $employeeId = $employee::where("f_department_id", 2)->select("id")->get()->toArray();
            $employeeIds = [0];
            foreach ($employeeId as $k => $v) {
                $employeeIds[] = $v['id'];
            }
        }
        if ($info['employee']) {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']],["signin_name","like","%{$info["signin_name"]}%"]])->whereNotIn("signin_name",employeePhone())->get();
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']], ["f_employee_id", $info['employee']]])->count();
        } else {
            $userInfos = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']],["signin_name","like","%{$info["signin_name"]}%"]])->whereIn("f_employee_id", $employeeIds)->whereNotIn("signin_name",employeePhone())->get();
            $count = $user::with("employee")->where([["bind_employee_time", ">=", $info['start_time']], ['bind_employee_time', "<=", $info['end_time']]])->whereIn("f_employee_id", $employeeIds)->count();
        }

        $userInfo = $userInfos->toArray();
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();
            //获取所有销售员工
            $employeeInfo = $employee::where("f_department_id", 2)->get()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
            $areaIds = [];
            foreach ($areaInfo as $k => $v) {
                $areaIds[] = $v['id'];
            }
            $employeeInfo=$employee::where("f_department_id", 2)->whereIn("f_area_id",$areaIds)->get()->toArray();
        }
        //整成一维数组
        $data[] = [
            '编号',
            '账户',
            '用户名',
            '酒店名称',
            '所在地区',
            '注册时间',
            '绑定时间',
            '绑定时所属员工'
        ];
        foreach($userInfo as $k=>$v){
            $temp_change["id"] = $v["id"];
            $temp_change["signin_name"] = $v["signin_name"];
            $temp_change["username"] = $v["username"]?$v["username"]:"未填写";
            $temp_change["hotel_name"] = $v["hotel_name"]?$v["hotel_name"]:"未填写";
            if ($v["employee"]["f_area_id"] == 0){
                $temp_change["area"] = "未绑定";
            }else{
                foreach ($areaInfo as $kk=>$vv){
                    if ($v["employee"]["f_area_id"] == $vv["id"]){
                        $temp_change["area"]= $vv["name"];
                    }
                }
            }
            $temp_change["create_time"] = date("Y-m-d H:i:s",$v["create_time"]);
            $temp_change["bind_employee_time"] = $v['bind_employee_time']?date("Y-m-d H:i:s",$v['bind_employee_time']):"未绑定";
            $temp_change["employee"] = $v["employee"]?$v["employee"]["username"]:"未绑定";
            $data[] = $temp_change;
        }
        Excel::create("change",function($excel) use ($data){
            $excel->sheet("change",function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export("xls");
    }

    //注册图表导出
    public function registerChartExport(Area $area,User $user,Request $request,Employee $employee)
    {
        $info['min_time']=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info['max_time']=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['area']=$request->input("area")?$request->input("area"):0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area'])
        {
            $areaIds=$area->where("id",$info['area'])->orWhere("parent_id",$info['area'])->get()->toArray();
            foreach ($areaIds as $k=>$v)
            {
                $areaId[]=$v['id'];
            }
        }else
        {
            $areaIds=$area->get()->toArray();
            foreach ($areaIds as $k=>$v)
            {
                $areaId[]=$v['id'];
            }
        }
        $orderBys=$user->select(DB::raw("f_employee_id,count(*) as count"))->where([["bind_employee_time",">=",$info['min_time']],["bind_employee_time","<=",$info['max_time']]])->whereNotIn("f_employee_id",[0,1,70])->groupBy("f_employee_id")->orderBy("count","desc")->get()->toArray();
        $orderBy=[];
        foreach ($orderBys as $k=>$v)
        {
            $orderBy[]=$v["f_employee_id"];
        }
        $employeeId=$employee::where("f_department_id",2)->whereNotIn("id",[0,1,70])->select(DB::raw("GROUP_CONCAT(id) as ids"))->first()->toArray();
        $employeeId=explode(",",$employeeId["ids"]);
        foreach ($employeeId as $k=>$v)
        {
            if (!in_array($v,$orderBy))
            {
                $orderBy[]=$v;
            }
        }
        $orderByz=implode(",",$orderBy);
        $page=$request->input("page")?$request->input("page"):1;
        $employeeInfos=$employee::with(["user"=>function($query) use ($info)
        {
            $query->where([["bind_employee_time",">=",$info['min_time']],["bind_employee_time","<=",$info['max_time']]]);
        }])->whereIn("id",$orderBy)->whereIn("f_area_id",$areaId)->orderByRaw(DB::raw("FIELD(id,$orderByz)"))->get();
        $employeeInfo=$employeeInfos->toArray();

        //获取所有的地区
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
        }

        //整成一维数组
        $data[] = [
            '排行',
            '员工姓名',
            '用户注册量',
            '地区',
        ];
        $i=0;
        foreach($employeeInfo as $k=>$v){
            $temp['no']=++$i;
            $temp["username"] = $v['username'];
            $temp['registercount'] = count($v['user']);
            $temp['area'] = "";
            foreach($areaInfo as $kk=>$vv){
                if ($v['f_area_id'] == $vv['id']){
                    $temp['area'] = $vv['name'];
                }
            }
            $data[] = $temp;
        }
        Excel::create('registerChart',function($excel) use ($data){
            $excel->sheet('registerChart', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }

    //成交图表导出
    public function moneyChartExport(Area $area,Employee $employee,User $user,Request $request)
    {
        $info['min_time']=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info['max_time']=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['area']=$request->input("area")?$request->input("area"):0;
        if (session("employeeInfo")["f_area_id"]!=1&&$info['area']==0)
        {
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if (session("employeeInfo")["f_area_id"]==1&&$info['area']==0&&session("employeeInfo")["f_employee_type_id"]!=1){
            $info['area']=session("employeeInfo")["f_area_id"];
        }
        if ($info['area'])
        {
            $areaIds=$area->where("id",$info['area'])->orWhere("parent_id",$info['area'])->get()->toArray();
            foreach ($areaIds as $k=>$v)
            {
                $areaId[]=$v['id'];
            }
        }else
        {
            $areaIds=$area->get()->toArray();
            foreach ($areaIds as $k=>$v)
            {
                $areaId[]=$v['id'];
            }
        }
        //用户表
        $orderInfo=$user::with(["order"=>function($query) use($info)
        {
            $query->where([["create_time",">=",$info["min_time"]],["create_time","<=",$info["max_time"]]]);
            $query->whereIn("f_order_form_status_id",[2,4,5,14,15]);
        }])->whereNotIn("f_employee_id",[0,1,70])->get()->groupBy("f_employee_id")->toArray();

        //计算员工订单成交额
        foreach ($orderInfo as $k=>$v)
        {
            $temp=0;
            foreach ($v as $k1=>$v1)
            {
                foreach ($v1['order'] as $k2=>$v2)
                {
                    if ($v1['bind_employee_time']<$v2['create_time'])
                    {
                        if (in_array($v2['f_pay_type_id'],[14,15,16]))
                        {
                            $temp+=intval($v2['discount_price']*100);
                        }else
                        {
                            $temp+=intval($v2['price']*100);
                        }
                    }
                }
            }
            $price[$k]=$temp;
        }
        arsort($price);
        foreach ($price as $k=>$v)
        {
            $orderBy[]=$k;
        }
        $employeeId=$employee::where("f_department_id",2)->whereNotIn("id",[0,1,70])->select(DB::raw("GROUP_CONCAT(id) as ids"))->first()->toArray();
        $employeeId=explode(",",$employeeId["ids"]);
        foreach ($employeeId as $k=>$v)
        {
            if (!in_array($v,$orderBy))
            {
                $orderBy[]=$v;
                $price[$v]=0;
            }
        }
        $orderByz=implode(",",$orderBy);
        $employeeInfos=$employee::with(["user"=>function($query) use ($info)
        {
            $query->where([["bind_employee_time",">=",$info['min_time']],["bind_employee_time","<=",$info['max_time']]]);
        }])->whereIn("id",$orderBy)->whereIn("f_area_id",$areaId)->orderByRaw(DB::raw("FIELD(id,$orderByz)"))->get();
        $employeeInfo=$employeeInfos->toArray();
        $page=$request->input("page")?$request->input("page"):1;
        //获取所有的地区
        if (session("employeeInfo")["f_area_id"]==1&&session("employeeInfo")["f_employee_type_id"]==1)
        {
            //获取所有地区
            $areaInfo = $area::all()->toArray();

        }else{
            $areaInfo = Area::where('id', session("employeeInfo")["f_area_id"])->orWhere("parent_id", session("employeeInfo")["f_area_id"])->get()->toArray();
        }
        $info['min_time']=date("Y年m月d日",$info['min_time']);
        $info['max_time']=date("Y年m月d日",$info['max_time']);

        //整成一维数组
        $data[] = [
            '排行',
            '员工姓名',
            '用户成交额',
            '地区',
        ];

        $i=0;
        foreach($employeeInfo as $k=>$v){
            $temp_money["no"] = ++$i;
            $temp_money["username"] = $v['username'];
            $temp_money['userTurnover'] = number_format($price[$v['id']]/100,2,".","");
            $temp_money['area1'] = "";
            foreach($areaInfo as $kk=>$vv){
                if ($v['f_area_id'] == $vv['id']){
                    $temp_money['area1'] = $vv['name'];
                }
            }
            $data[] = $temp_money;
        }
        Excel::create('moneyChart',function($excel) use ($data){
            $excel->sheet('moneyChart', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }
}
