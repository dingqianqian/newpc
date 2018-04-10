<?php

namespace App\Http\Controllers\Admin;

use App\Model\Area;
use App\Model\Goods;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class CensusController extends Controller
{
    //流量统计
    public function traffic(Request $request)
    {
        //从后台模板接收开始时间  年月日
        $jintian = date('Y年m月d日',strtotime('- 30days'));
        $btime = $request->input("btime") ? $request->input("btime") : "$jintian";  //开始时间
        //去掉年月日 getTimeStamp函数
        $btime = getTimeStamp($btime);
        //实例化百度统计类
        $baiduTongji = resolve('BaiduTongji');
        $btime = strtotime($btime);    //开始时间戳
        $eetime = date('Ymd',strtotime("-1 days"));  //永远是当天的时间
        $etime = $btime+3600*24*30;   //结束时间戳 时间戳加上秒数
        $btime = date('Ymd',$btime);  //转换成 20170802 格式
        $etime = date('Ymd',$etime);
        //取数据 pv uv
        $res = $baiduTongji->getData([
            'method' => 'trend/time/a',
            'start_date' => $btime,
            'end_date' => $etime,
            'metrics' => 'pv_count,visitor_count',
            'max_results' => 0,
            'gran' => 'day',
        ]);
        //实际搜索的30天
        for ($i=0;$i<30;$i++)
        {
            $date[]=date("Y/m/d",strtotime($btime)+3600*24*$i);
        }
        foreach ($res['items'][0] as $k=>$v)
        {
            $resPvUv[$v[0]]['pv']=$res['items'][1][$k][0]=="--"?0:$res['items'][1][$k][0];
            $resPvUv[$v[0]]['uv']=$res['items'][1][$k][1]=="--"?0:$res['items'][1][$k][1];
        }
        foreach ($date as $k=>$v)
        {
            if (isset($resPvUv[$v]))
            {
                $resPvUvEnd[$v]=$resPvUv[$v];
            }else
                {
                    $resPvUvEnd[$v]=["pv"=>0,"uv"=>0];
                }
        }
        $pvMax=getArrayMax($resPvUvEnd,"pv")*2?intval(getArrayMax($resPvUvEnd,"pv")*2):10;
        $uvMax=getArrayMax($resPvUvEnd,"uv")*2?intval(getArrayMax($resPvUvEnd,"uv")*2):10;
        //dd($resPvUvEnd);
        /*------------------------------地图 pv 占比 -----------------------------*/
        //取数据 地区按省 pv 占比
        $res_diqu = $baiduTongji->getData([
            'method' => 'visit/district/a',
            'start_date' => $btime,
            'end_date' => $etime,
            'metrics' => 'pv_count',
            'max_results' => 0,
        ]);
        //dd($res_diqu);
        //百度给的数据
        foreach ($res_diqu['items'][0] as $k=>$v)
        {
            $resMap[$v[0]['name']]=$res_diqu['items'][1][$k][0];
        }
        $allsheng = [
            1=>'黑龙江',
            2=>'吉林',
            3=>'辽宁',
            4=>'内蒙古',
            5=>'河北',
            6=>'山东',
            7=>'江苏',
            8=>'浙江',
            9=>'福建',
            10=>'广东',
            11=>'海南',
            12=>'台湾',
            13=>'新疆',
            14=>'西藏',
            15=>'云南',
            16=>'广西',
            17=>'西藏',
            18=>'甘肃',
            19=>'青海',
            20=>'四川',
            21=>'贵州',
            22=>'湖南',
            23=>'江西',
            24=>'宁夏',
            25=>'陕西',
            26=>'山西',
            27=>'河南',
            28=>'安徽',
            29=>'湖北',
            30=>'重庆',
            31=>'贵州',
            32=>'湖南',
            33=>'北京',
            34=>'上海',
            35=>'台湾',
            36=>'海南',
            37=>'天津'
        ];

        foreach ($allsheng as $k=>$v)
        {
            if (isset($resMap[$v]))
            {
                $resMapEnd[$v]=$resMap[$v];
            }else
                {
                    $resMapEnd[$v]=0;
                }
        }
        //取最大值 省的pv
        $mapMax = getLargeInt(max($resMapEnd));  //省 pv
        /*---------------------------新访客 跳出率 平均访问时长 平均访问页数-----------------------*/
        //取数据 新访客的数据
        if (Cache::has("res_new"))
        {
            $res_new=Cache::get("res_new");
        }else
            {
                $res_new = $baiduTongji->getData([
                    'method' => 'trend/time/a',
                    'start_date' => $eetime,
                    'end_date' => $eetime,
                    'metrics' => 'pv_count,visitor_count,bounce_ratio,avg_visit_time,avg_visit_pages',
                    'max_results' => 0,
                    'visitor'=>'new',
                    'gran' => 'day'
                ]);
                Cache::put("res_new",$res_new,120);
            }
        /*---------------------------老访客 跳出率 平均访问时长 平均访问页数-----------------------*/
        //取数据 老访客的数据
        if (Cache::has("res_old"))
        {
            $res_old=Cache::get("res_old");
        }else
            {
                $res_old = $baiduTongji->getData([
                    'method' => 'trend/time/a',
                    'start_date' => $eetime,
                    'end_date' => $eetime,
                    'metrics' => 'pv_count,visitor_count,bounce_ratio,avg_visit_time,avg_visit_pages',
                    'max_results' => 0,
                    'visitor'=>'old',
                    'gran' => 'day'
                ]);
                Cache::put("res_old",$res_old,120);
            }
        /*---------------------------受访页面 pv 占比-----------------------*/
        //取数据
        if (Cache::has("viewPage"))
        {
            $viewPage=Cache::get("viewPage");
        }else
            {
                $viewPage = $baiduTongji->getData([
                    'method' => 'visit/toppage/a',
                    'start_date' => $eetime,
                    'end_date' => $eetime,
                    'metrics' => 'pv_count,pv_ratio',
                    'max_results' => 10
//            'target'=>1
//            'gran' => 'day'
                ]);
                Cache::put("viewPage",$viewPage,120);
            }
        /*-------------------------来源网站 pv 占比-----------------------*/
        //取数据
        if (Cache::has("res"))
        {
            $res6=Cache::get("res6");
        }else{
            $res6 = $baiduTongji->getData([
                'method' => 'overview/getCommonTrackRpt',
                'start_date' => $eetime,
                'end_date' => $eetime,
                'metrics' => 'pv_count,pv_ratio',
                'max_results' => 0
            ]);
            Cache::put("res6",$res6,120);
        }
        //格式 整成二维数组
        $source_site=[];
        foreach ($res6['sourceSite']['items'] as $k=>$v){
            $source_site[] = $v;
        }
        if ($res_new['items'][1][0][1]+$res_old['items'][1][0][1])
        {
            $percent=round($res_old['items'][1][0][1]/($res_new['items'][1][0][1]+$res_old['items'][1][0][1])*100,2);
        }else
            {
                $percent=0;
            }
        /*---------------------------最后 显示选定的日期-----------------------*/
        //显示选定的日期
        $btime = strtotime($btime);
        $btime = date('Y年m月d日',$btime);
        return view("admin.census.traffic",compact("resPvUvEnd",'resMapEnd','btime',"pvMax","uvMax",'mapMax','tickInterval','tickInterval_uv','res_new','res_old','res6','source_site','viewPage',"percent"));
    }
    //客户统计
    public function user(User $user,Request $request,Area $area)
    {
        $info['time']=$request->input("start_time")?strtotime(getTimeStamp($request->input("start_time"))):strtotime(date("Y-m-d",strtotime("-30 days")));
        //获取最近30天的注册用户量
        $areaIds=[];
        if (session("employeeInfo")['f_area_id']!=1)
        {
            $areaInfo=$area->where("id",session("employeeInfo")['f_area_id'])->orWhere("parent_id",session("employeeInfo")['f_area_id'])->select('id')->get()->toArray();
        }else
            {
                $areaInfo=$area::all()->toArray();
            }
        foreach ($areaInfo as $k=>$v)
        {
            $areaIds[]=$v['id'];
        }
        $userInfo=$user->select(DB::raw("FROM_UNIXTIME(create_time,'%Y%m%d') as date"))->where([["create_time",">=",$info['time']],["create_time","<=",$info['time']+3600*24*30]])->whereIn("f_area_id",$areaIds)->get()->groupBy("date")->toArray();
        for ($i=0;$i<30;$i++)
        {
            $date[]=date("Ymd",$info['time']+3600*24*$i);
        }
        foreach ($date as $k=>$v)
        {
            if (isset($userInfo[$v]))
            {
                $temp[$v]=count($userInfo[$v]);
            }else
                {
                    $temp[$v]=0;
                }
        }
        $info['time']=date("Y年m月d日",$info['time']);
        //会员占比
        $userCount=$user->whereIn("f_area_id",$areaIds)->count();
        $vipCount=$user->whereIn("f_area_id",$areaIds)->where("f_vip_level_id",2)->count();
        $percent=round($vipCount/$userCount,2)*100;
        return view("admin.census.user",compact("temp","info","percent"));
    }
    //销售统计
    public function sell(Request $request,User $user,Order $order,Area $area,OrderGoods $orderGoods,Goods $goods)
    {
        $info['time']=$request->input("start_time")?strtotime(getTimeStamp($request->input("start_time"))):strtotime(date("Y-m-d",strtotime("-30 days")));
        $info['area']=$request->input("area")?$request->input("area"):0;
        if (!$info['area'])
        {
            $info['area']=session("employeeInfo")['f_area_id'];
        }
        //地区
        $areaIds=[];
        if ($info['area'])
        {
            $areaInfo=$area->where("id",$info['area'])->orWhere("parent_id",$info['area'])->select('id')->get()->toArray();
            foreach ($areaInfo as $k=>$v)
            {
                $areaIds[]=$v['id'];
            }
        }else
        {
            $areaIds=[0];
            $areaInfo=$area->select('id')->get()->toArray();
            foreach ($areaInfo as $k=>$v)
            {
                $areaIds[]=$v['id'];
            }
        }
        for ($i=0;$i<30;$i++)
        {
            $date[]=date("Ymd",$info['time']+3600*24*$i);
        }
        //订单统计（数量）
        $orderInfo=$order->where([["create_time",">=",$info['time']],["create_time","<=",$info['time']+3600*24*30]])->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn("f_area_id",$areaIds)->select(DB::raw("*,FROM_UNIXTIME(create_time,'%Y%m%d') as date"))->get()->groupBy("date")->toArray();
        foreach ($date as $k=>$v)
        {
            if (isset($orderInfo[$v]))
            {
                $count[$v]=count($orderInfo[$v]);
            }else
            {
                $count[$v]=0;
            }

        }
        //订单价格
        foreach ($date as $k=>$v)
        {
            $temp=0;
            if (isset($orderInfo[$v]))
            {
                foreach ($orderInfo[$v] as $k1=>$v1)
                {
                    $temp+=$v1['price'];
                }
                $price[$v]=$temp;
                $temp=0;
            }else
            {
                $price[$v]=0;
            }
        }
        $info['start_time']=date("Y年m月d日",$info['time']);
        //商品畅销比例
        $orderGoodsInfo=$orderGoods::leftJoin("order_form","order_goods.f_order_form_no","order_form.no")->select("order_goods.f_goods_id","order_goods.number","order_goods.deal_min_price")->whereIn("f_area_id",$areaIds)->get()->groupBy("f_goods_id")->toArray();
        if ($orderGoodsInfo)
        {
            $sellNumber=[];
            $sellMoney=[];
            foreach ($orderGoodsInfo as $k=>$v)
            {
                $sellNumber[$k]=count($v);
                $priceTemp=0;
                foreach ($v as $k1=>$v1)
                {
                    $priceTemp+=$v1['number']*$v1['deal_min_price'];
                }
                $sellMoney[$k]=$priceTemp;
            }
            arsort($sellNumber);
            arsort($sellMoney);
            $goodsSort=implode(",",array_keys($sellNumber));
            $goodsSort2=implode(",",array_keys($sellMoney));
            $goodsSellNumber=$goods->where("id","!=",619)->whereIn("id",array_keys($sellNumber))->orderByRaw(DB::raw("FIELD(id,$goodsSort)"))->limit(10)->get()->toArray();
            $goodsSellMoney=$goods->where("id","!=",619)->whereIn("id",array_keys($sellMoney))->orderByRaw(DB::raw("FIELD(id,$goodsSort2)"))->limit(10)->get()->toArray();
            foreach ($sellNumber as $k=>$v)
            {
                $sellNumberPercent[$k]=round($v/array_sum($sellNumber),2)*100;
            }
            $areaInfo=$area::all()->toArray();
        }else
            {
                $goodsSellNumber=[];
                $sellNumber=[];
                $sellNumberPercent=[];
                $goodsSellMoney=[];
                $sellMoney=[];
            }
            if (session("employeeInfo")['f_area_id']!=1)
            {
                $areaInfo=$area::where("id",session("employeeInfo")['f_area_id'])->orWhere("parent_id",session("employeeInfo")['f_area_id'])->get()->toArray();
            }else
                {
                    $areaInfo=$area::all()->toArray();
                }
        return view("admin.census.sell",compact("price","count","areaInfo","info","goodsSellNumber","sellNumber","sellNumberPercent","goodsSellMoney","sellMoney"));
    }
    //订单统计
    public function order(Request $request,User $user,Order $order,Area $area)
    {
        $info['time']=$request->input("start_time")?strtotime(getTimeStamp($request->input("start_time"))):strtotime(date("Y-m-d",strtotime("-30 days")));
        $info['area']=$request->input("area")?$request->input("area"):0;
        if (!$info['area'])
        {
            $info['area']=session("employeeInfo")['f_area_id'];
        }
        //黄金会员量
        $vipIds=$user->where("f_vip_level_id",2)->select('id')->get()->toArray();
        $vipId=[];
        foreach ($vipIds as $k=>$v)
        {
            $vipId[]=$v['id'];
        }
        //地区
        $areaIds=[];
        if ($info['area'])
        {
            $areaInfo=$area->where("id",$info['area'])->orWhere("parent_id",$info['area'])->select('id')->get()->toArray();
            foreach ($areaInfo as $k=>$v)
            {
                $areaIds[]=$v['id'];
            }
        }else
        {
            $areaIds=[0];
            $areaInfo=$area->select('id')->get()->toArray();
            foreach ($areaInfo as $k=>$v)
            {
                $areaIds[]=$v['id'];
            }
        }
        //订单统计（数量）
        $orderInfo=$order->where([["create_time",">=",$info['time']],["create_time","<=",$info['time']+3600*24*30]])->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn("f_area_id",$areaIds)->select(DB::raw("*,FROM_UNIXTIME(create_time,'%Y%m%d') as date"))->get()->groupBy("date")->toArray();
        //普通会员
        $orderInfoP=$order->where([["create_time",">=",$info['time']],["create_time","<=",$info['time']+3600*24*30]])->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn("f_area_id",$areaIds)->whereNotIn("f_user_id",$vipId)->select(DB::raw("*,FROM_UNIXTIME(create_time,'%Y%m%d') as date"))->get()->groupBy("date")->toArray();
        //黄金会员
        $orderInfoH=$order->where([["create_time",">=",$info['time']],["create_time","<=",$info['time']+3600*24*30]])->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn("f_area_id",$areaIds)->whereIn("f_user_id",$vipId)->select(DB::raw("*,FROM_UNIXTIME(create_time,'%Y%m%d') as date"))->get()->groupBy("date")->toArray();
        for ($i=0;$i<30;$i++)
        {
            $date[]=date("Ymd",$info['time']+3600*24*$i);
        }
        //计算订单量
        foreach ($date as $k=>$v)
        {
            if (isset($orderInfo[$v]))
            {
                $count[$v]=count($orderInfo[$v]);
            }else
            {
                $count[$v]=0;
            }
            if (isset($orderInfoP[$v]))
            {
                $countP[$v]=count($orderInfoP[$v]);
            }else
            {
                $countP[$v]=0;
            }
            if (isset($orderInfoH[$v]))
            {
                $countH[$v]=count($orderInfoH[$v]);
            }else
            {
                $countH[$v]=0;
            }

        }
        //dd($orderInfo);
        //计算价格
        //计算订单量
        foreach ($date as $k=>$v)
        {
            $temp=0;
            if (isset($orderInfo[$v]))
            {
               foreach ($orderInfo[$v] as $k1=>$v1)
               {
                   $temp+=$v1['price'];
               }
               $price[$v]=$temp;
               $temp=0;
            }else
            {
                $price[$v]=0;
            }
            if (isset($orderInfoP[$v]))
            {
                foreach ($orderInfoP[$v] as $k1=>$v1)
                {
                    $temp+=$v1['price'];
                }
                $priceP[$v]=$temp;
                $temp=0;
            }else
            {
                $priceP[$v]=0;
            }
            if (isset($orderInfoH[$v]))
            {
                foreach ($orderInfoH[$v] as $k1=>$v1)
                {
                    $temp+=$v1['price'];
                }
                $priceH[$v]=$temp;
                $temp=0;
            }else
            {
                $priceH[$v]=0;
            }

        }
        $info['start_time']=date("Y年m月d日",$info['time']);
        if (session("employeeInfo")['f_area_id']!=1)
        {
            $areaInfo=$area::where("id",session("employeeInfo")['f_area_id'])->orWhere("parent_id",session("employeeInfo")['f_area_id'])->get()->toArray();
        }else
        {
            $areaInfo=$area::all()->toArray();
        }
        //订单金额(总)
        $orderPrice=$order->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn("f_area_id",$areaIds)->where("f_pay_type_id","!=",0)->sum("price");
        $orderCount=$order->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn("f_area_id",$areaIds)->where("f_pay_type_id","!=",0)->count();
        if ($orderCount)
        {
            //支付方式比例
            $weixinPercent=round($order::whereIn("f_pay_type_id",[2,3,5,7,12])->whereIn("f_area_id",$areaIds)->whereIn("f_order_form_status_id",[2,4,5,14,15])->count()/$orderCount,2)*100;
            $aliPayPercent=round($order::whereIn("f_pay_type_id",[1,6,8,13])->whereIn("f_area_id",$areaIds)->whereIn("f_order_form_status_id",[2,4,5,14,15])->count()/$orderCount,2)*100;
            $walletPercent=round($order::whereIn("f_pay_type_id",[4,9,10])->whereIn("f_area_id",$areaIds)->whereIn("f_order_form_status_id",[2,4,5,14,15])->count()/$orderCount,2)*100;
        }else{
            $weixinPercent=100;
            $aliPayPercent=0;
            $walletPercent=0;
        }
        if ($orderPrice)
        {
            //金额占比
            $weixinPrice=round($order::whereIn("f_pay_type_id",[2,3,5,7,12])->whereIn("f_area_id",$areaIds)->whereIn("f_order_form_status_id",[2,4,5,14,15])->sum("price")/$orderPrice,2)*100;
            $aliPayPrice=round($order::whereIn("f_pay_type_id",[1,6,8,13])->whereIn("f_area_id",$areaIds)->whereIn("f_order_form_status_id",[2,4,5,14,15])->sum("price")/$orderPrice,2)*100;
            $walletPrice=round($order::whereIn("f_pay_type_id",[4,9,10])->whereIn("f_area_id",$areaIds)->whereIn("f_order_form_status_id",[2,4,5,14,15])->sum("price")/$orderPrice,2)*100;
        }else{
            $weixinPrice=100;
            $aliPayPrice=0;
            $walletPrice=0;
        }
        return view("admin.census.order",compact("count","countP","countH","info","price","priceH","priceP","areaInfo","orderPrice","orderCount","weixinPercent","aliPayPercent","walletPercent","weixinPrice","aliPayPrice","walletPrice"));
    }
}
