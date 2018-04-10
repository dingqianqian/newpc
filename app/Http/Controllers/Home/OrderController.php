<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\IdsRequest;
use App\Http\Requests\OrderRequest;
use App\Model\Coupon;
use App\Model\Custom;
use App\Model\Goods;
use App\Model\GoodsDetailsImg;
use App\Model\GoodsImg;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\NormsComboImg;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\ShopCart;
use App\Model\TakeOver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //订单生成
    public function create(IdsRequest $request,NormsCombo $normsCombo,ShopCart $shopCart,Norms $norms,GoodsImg $goodsImg,TakeOver $takeOver,Coupon $coupon,$areaID=0,$takeOverID=0,Custom $custom)
    {
        //获取用户购物车的信息
        $id=trim($request->input("id"),",");
        if (!$id)
        {
            return redirect("/");
        }
        $id=explode(",",$id);
        if ($areaID==0)
        {
            $f_area_id=session("f_area_info")['id'];
        }else{
            $f_area_id=$areaID;
        }
        $shopInfo=$shopCart->whereIn("id",$id)->get()->toArray();
        if ($shopInfo)
        {
            foreach ($shopInfo as $k=>$v)
            {
                $temp=$normsCombo->getGoodsInfo($norms,$goodsImg,$v["f_goods_id"],$v["f_norms_combo_id"],$f_area_id);
                $temp["cart"]=$v;
                $temp["cart"]['custom_name']=$custom->where("id",$v["f_custom_id"])->value("hotel_name");
                $temp["cart"]['custom_delete']=$custom->where("id",$v["f_custom_id"])->value("is_delete");
                $shopCartInfo[]=$temp;
            }
        }else
        {
            $shopCartInfo=[];
        }
        //过滤已经删除掉的商品
        $temp=[];
        foreach ($shopCartInfo as $k=>$v)
        {
            if (isset($v["err"]))
            {
                continue;
            }
            if($v['cart']['custom_delete'] !=0 )
            {
                continue;
            }
            $temp[]=$v;

        }
        $shopCartInfo=$temp;
        $count=0;
        foreach ($shopCartInfo as $k=>$v)
        {
            if (is_11121())
            {
                $price=intval($v["sale_single_price"]*100)*$v["cart"]["number"];

            }else
                {
                    $price=intval($v["single_price"]*100)*$v["cart"]["number"];

                }
            $arr[]=$price;
            $count+=$price;
        }
        //获取用户的收货地址
        $takeOverInfo=$takeOver->getAll(session("userInfo")["id"]);
        foreach ($takeOverInfo as $k=>$v)
        {
            if ($v['id']==$takeOverID)
            {
                $temp=$takeOverInfo[0];
                $takeOverInfo[0]=$takeOverInfo[$k];
                $takeOverInfo[$k]=$temp;
            }
        }
        //dd(count($takeOverInfo));
        //获取用户可用优惠券列表(先更新过期和活动未开始优惠券)
        $coupon->where([["f_user_id",session("userInfo")['id']],["expire_time_end","<",time()]])->update(["f_coupon_status_id"=>3]);
        $coupon->where([["f_user_id",session("userInfo")['id']],["expire_time_start",">",time()]])->update(["f_coupon_status_id"=>2]);
        if (!$areaID)
        {
            if (session('f_area_info')['id']==372)
            {
                $areaID=256;
            }else
            {
                $areaID=session('f_area_info')['id'];
            }
        }
        if ($areaID==372)
        {
            $areaID=256;
        }
        $couponInfo=$coupon::with("couponType")->where([["f_user_id",session("userInfo")["id"]],["start_price","<",$count/100],["f_coupon_status_id",1],["expire_time_start","<",time()],["expire_time_end",">",time()]])->whereIn("f_area_id",[0,$areaID])->get()->toArray();
        $id=$request->input("id");
        return view("home.order.create",compact("shopCartInfo","count","takeOverInfo","couponInfo","id","areaID","takeOverID"));
    }
    //生成订单
    public function add(OrderRequest $request,Coupon $coupon,ShopCart $shopCart,NormsCombo $normsCombo,Norms $norms,GoodsImg $goodsImg,TakeOver $takeOver,Order $order,OrderGoods $orderGoods)
    {
        $addID=$request->input("addrId");
        $cartID=explode(',',trim($request->input("cartId"),","));
        $explain=$request->input("explain");
        $couponId=$request->input("couponId");
        //获取用户收货地址
        $takeOverInfo=$takeOver->where([["id",$addID],["f_user_id",session("userInfo")["id"]]])->first();
        //计算购物车所有商品
        $shopInfo=$shopCart->whereIn("id",$cartID)->get()->toArray();
        //dd($shopInfo);
        if ($shopInfo)
        {
            foreach ($shopInfo as $k=>$v)
            {
                $temp=$normsCombo->getGoodsInfo($norms,$goodsImg,$v["f_goods_id"],$v["f_norms_combo_id"],$takeOverInfo->f_area_id);
                $temp["cart"]=$v;
                $shopCartInfo[]=$temp;
            }
        }else
        {
            $shopCartInfo=[];
        }
        //过滤已经删除掉的商品
        $temp=[];
        foreach ($shopCartInfo as $k=>$v)
        {
            if (isset($v["err"]))
            {
                continue;
            }
            $temp[]=$v;

        }
        $shopCartInfo=$temp;
        $count1=0;
        $count2=0;
        if (!$shopCartInfo)
        {
            return ["err"=>500,"msg"=>"生成订单失败,请不要重复生成订单"];
        }
        foreach ($shopCartInfo as $k=>$v)
        {

            $price1=intval($v["sale_single_price"]*100)*$v["cart"]["number"];
            $price2 = intval($v["single_price"] * 100) * $v["cart"]["number"];
            $count2+=$price2;
            $count1+=$price1;
        }
        if (is_11121())
        {
            $data["price"]=$count1/100;
            $data["discount_price"]=0;
            $data["wechat_total_fee"]=$count1;
        }else
            {
                $data["price"]=$count2/100;
                $data["discount_price"]=0;
                $data["wechat_total_fee"]=$count2;
            }
            if (is_11121())
            {
                $count=$count1;
            }else{
                $count=$count2;
            }
        //判断是否存在优惠券
        if ($couponId)
        {
            $couponInfo=$coupon->where([["id",$couponId],["f_user_id",session("userInfo")["id"]]])->first();
            if ($couponInfo->f_coupon_status_id==1)
            {
                $couponInfo->f_coupon_status_id=4;
                $couponInfo->use_time=time();
                if ($couponInfo->save())
                {
                    $count=$count-intval($couponInfo->use_value*100);
                    $data["price"]=$count/100;
                    $data["wechat_total_fee"]=$count;
                    $data['f_coupon_no']=$couponInfo->no;
                }else{
                    return ["err"=>404,"msg"=>"使用优惠券失败"];
                }
            }
        }
        $data["f_user_id"]=session("userInfo")["id"];
        $data["create_time"]=time();
        $data["no"]=make_no();
        $data["f_order_form_status_id"]=3;
        if ($takeOverInfo){
            $data["f_area_id"]=$takeOverInfo->f_area_id;
            $data["take_over_name"]=$takeOverInfo->name;
            $data["take_over_company"]=$takeOverInfo->company_name;
            if (mb_substr($takeOverInfo->province,0,2)==mb_substr($takeOverInfo->city,0,2))
            {
                $data["take_over_addr"]=$takeOverInfo->province.' '.$takeOverInfo->town.' '.$takeOverInfo->ex;
            }else{
                $data["take_over_addr"]=$takeOverInfo->province.' '.$takeOverInfo->city.' '.$takeOverInfo->town.' '.$takeOverInfo->ex;
            }
            $data["take_over_tel_no"]=$takeOverInfo->tel_no;
        }else
            {
                return ["err"=>404,"msg"=>"找不到收货地址信息"];
            }

        //订单留言
        if ($explain)
        {
            $data["remark"]=$explain;
        }
        $data["bc_id"]=0;
        $data["integral"]=floor($data["price"]/100);
        $data["pay_return_code"]=0;
        $info=$order->create($data);
        if ($info)
        {
            //清空购物车
            if($shopCart::destroy($cartID))
            {
                foreach ($shopCartInfo as $k=>$v)
                {
                    $orderGoodsInfo["f_order_form_no"]=$data["no"];
                    $orderGoodsInfo["f_goods_id"]=$v["goods"]["id"];
                    $orderGoodsInfo["f_norms_id"]=$v["f_norms_id"];
                    $orderGoodsInfo["number"]=$v["cart"]["number"];
                    $orderGoodsInfo["f_custom_id"]=$v["cart"]["f_custom_id"];
                    $orderGoodsInfo["deal_min_price"]=$v["single_price"];
                    //添加订单关联商品
                    $orderGoods->create($orderGoodsInfo);
                }
                return ["err"=>200,"msg"=>"生成订单成功","no"=>$data['no']];
            }else
                {
                    return ["err"=>500,"msg"=>"生成订单失败"];
                }
        }else
            {
                return ["err"=>500,"msg"=>"生成订单失败"];
            }
    }
    //订单支付
    public function pay(Order $order,Goods $goods,$no,OrderGoods $orderGoods,NormsCombo $normsCombo,Coupon $coupon)
    {
        $orderInfo=$order::with("orderGoods")->where([["no","$no"],['f_user_id',session("userInfo")["id"]]])->first();
        //dd($orderInfo);
        if (!$orderInfo)
        {
            abort(404);
        }
        //判断订单是否过期
        if ($orderInfo->create_time+3600*24<time())
        {
            $orderInfo->f_order_form_status_id=1;
            if ($orderInfo->save())
            {
                //过期订单还原优惠卷
                if ($orderInfo->f_coupon_no)
                {
                    $couponInfo=$coupon->where("no",$orderInfo->f_coupon_no)->first();
                    $couponInfo->f_coupon_status_id=1;
                    $couponInfo->use_time=0;
                    $couponInfo->save();
                    $orderInfo->f_coupon_no="";
                    $orderInfo->save();
                }
                abort(404);
            }
        }
        //判断订单是11121的但是不是当天的
        if(in_array(mb_substr($orderInfo->no,6,2),[1,11,21])&&date("Ymd")!=mb_substr($orderInfo->no,0,8))
       {
           $orderInfo->f_order_form_status_id=1;
           if ($orderInfo->save())
           {
               abort(404);
           }
       }
        //判断未过期的订单和今天是否是11121（）
        /*if (is_11121())
        {
            //判断订单不是11121下的单子

            if (!in_array(mb_substr($orderInfo->no,6,2),[1,11,21]))
            {
                //订单还原优惠卷
                if ($orderInfo->f_coupon_no)
                {
                    $couponInfo=$coupon->where("no",$orderInfo->f_coupon_no)->first();
                    $couponInfo->f_coupon_status_id=1;
                    $couponInfo->use_time=0;
                    $couponInfo->save();
                }
                //查询订单的商品
                $orderGoodsInfo=$orderGoods->where("f_order_form_no",$orderInfo->no)->get()->toArray();
                //遍历商品
                ////重新计算价格
                $price=0;
                foreach ($orderGoodsInfo as $k=>$v)
                {
                    $normsComboInfo=$normsCombo->where([["f_norms_id",$v["f_norms_id"]],["f_goods_id",$v["f_goods_id"]]])->first();
                    $temp=$orderGoods::where([["f_norms_id",$v["f_norms_id"]],["f_goods_id",$v["f_goods_id"]],["f_order_form_no",$orderInfo->no]])->first();
                    $temp->deal_min_price=$normsComboInfo["sale_single_price"];
                    $temp->save();
                    $price+=$v["number"]*intval($normsComboInfo["sale_single_price"]*100);
                }
                //dd($price);
                $orderInfo->price=$price/100;
                $orderInfo->wechat_total_fee=$price;
                $orderInfo->f_coupon_no="";
                $orderInfo->save();
            }
        }*/
        //订单已经支付
        if ($orderInfo->f_order_form_status_id==2)
        {
            return redirect("pay/success/".$orderInfo->no);
        }
        if ($orderInfo->f_order_form_status_id!=3)
        {
            abort(404);
        }
        if ($orderInfo)
        {

            $orderInfo=$orderInfo->toArray();
            if ($orderInfo["create_time"]+3600*24<time())
            {
                abort(404);
            }
            //dd($orderInfo);
            $goodsId=[];
            foreach ($orderInfo["order_goods"] as $k=>$v)
            {
                $goodsId[]=$v['f_goods_id'];
            }
            $goodsInfo=$goods->whereIn('id',$goodsId)->get()->toArray();
            $time=date("Y/m/d H:i:s",$orderInfo["create_time"]+3600*24);
            //dd($time);
            //dd($goodsInfo);
        }else
            {
                abort(404);
            }
        return view("home.order.pay",compact('time','goodsInfo','orderInfo'));
    }
    //订单状态查询
    public function status(Order $order,$no)
    {
        $orderInfo=$order->where("no",$no)->first();
        if (!$orderInfo)
        {
            return ["err"=>404,"msg"=>"订单不存在"];
        }
        if ($orderInfo->f_pay_type_id==0)
        {
            return ["err"=>403,"msg"=>"订单未支付"];
        }else
            {
                return ["err"=>200,"msg"=>"订单已支付"];
            }
    }
    //订单中心
    public function index(Request $request,OrderGoods $orderGoods,Goods $goods,NormsCombo $normsCombo,Order $order,$status=0)
    {
        //更新过期订单
        $order->where([["create_time","<",time()-3600*24],["f_order_form_status_id","3"]])->update(["f_order_form_status_id"=>1]);
        if (!is_11121()){
           DB::update('UPDATE order_form SET f_order_form_status_id =1 WHERE FROM_UNIXTIME(create_time,"%d") in (1,11,21) AND f_order_form_status_id=3');
        }
        //获取热卖推荐
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->whereIn("id",[563,647,645,567])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            $goodsInfo[$k]["image_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);
        }
        //获取全部订单
        switch ($status){
            case 0:
                $statu=[1,2,3,4,5,6,7,8,10,11,12,13,14,15];
                break;
            case 3:
                $statu=[3];
                break;
            case 2:
                $statu=[2];
                break;
            case 4:
                $statu=[4,5];
                break;
            case 14:
                $statu=[14,15];
                break;
            case 15:
                $statu=[14,15];
                break;
            case 1010:
                $statu=false;
                    break;
            default:
                $statu=[1,2,3,4,5,6,7,8,10,11,12,13,14,15];
                break;
        }
        //搜索结果页面
        if (!$statu)
        {
            //获取搜索订单（分页）
            $search=$request->input("search");
            if (mb_strlen($search)==18)
            {
                $orderInfos=$order::with('orderGoods',"orderFormStatus","area")->where([["f_user_id",session("userInfo")['id']],["no",$search]])->whereNotIn("f_order_form_status_id",[9])->orderBy("id","desc")->paginate(5);
            }else{
                //先查询用户的所有订单
                $no=$order->where("f_user_id",session("userInfo")['id'])->whereNotIn("f_order_form_status_id",[9])->select("no")->get()->toArray();
                foreach ($no as $k=>$v){
                    $nos[]=$v["no"];
                }
                $nos=$orderGoods->where("f_goods_id",$search)->whereIn("f_order_form_no",$nos)->select("f_order_form_no")->get()->toArray();
                if ($nos){
                    foreach ($nos as $k=>$v){
                        $noss[]=$v["f_order_form_no"];
                    }
                }else{
                    $noss=[];
                }
                $orderInfos=$order::with('orderGoods',"orderFormStatus","area")->where([["f_user_id",session("userInfo")['id'],["f_order_form_status_id","!=",9]]])->whereIn("no",$noss)->orderBy("id","desc")->paginate(5);
            }
        }else{
            //获取所有订单（分页）
            $orderInfos=$order::with('orderGoods',"orderFormStatus","area")->where("f_user_id",session("userInfo")['id'])->whereIn("f_order_form_status_id",$statu)->whereNotIn("f_order_form_status_id",[9])->orderBy("id","desc")->paginate(5);
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
                        $orderInfo['data'][$k]['is_evalute']=0;
                    }else{
                        $orderInfo['data'][$k]['is_evalute']=1;
                    }
                }else{
                    $orderInfo['data'][$k]['is_evalute']=0;
                }
                foreach ($v['order_goods'] as $k1=>$v1)
                {
                    //获取商品的图片
                    $goodsImg=$normsCombo::with('goodsImg')->where([["f_area_id",1],["f_goods_id",$v1['f_goods_id']],["f_norms_id","{$v1["f_norms_id"]}"]])->first();
                    if ($goodsImg)
                    {
                        $goodsImg=$goodsImg->toArray();
                        $orderInfo['data'][$k]['order_goods'][$k1]["img_url"]="http://".$normsCombo->setCache($goodsImg['goods_img']['thumb']);
                        $orderInfo['data'][$k]['order_goods'][$k1]["name"]=$goods->select("name")->where("id",$v1['f_goods_id'])->first()->toArray()["name"];
                    }else
                        {
                            $orderInfo['data'][$k]['order_goods'][$k1]["img_url"]="";
                            $orderInfo['data'][$k]['order_goods'][$k1]["name"]="";
                        }


                }
            }
        }else
        {
            $orderInfo['data']=[];
        }
        //获取各个订单的数量
        $data[3]=$order->where([["f_user_id",session("userInfo")['id']],["f_order_form_status_id",3]])->count();
        $data[2]=$order->where([["f_user_id",session("userInfo")['id']],["f_order_form_status_id",2]])->count();
        $data[4]=$order->where([["f_user_id",session("userInfo")['id']]])->whereIn("f_order_form_status_id",[4,5])->count();
        $data[14]=$order->where([["f_user_id",session("userInfo")['id']]])->whereIn("f_order_form_status_id",[14,15])->count();
        $index="order";
       // dd($orderInfo);
        return view("home.order.index",compact("index","goodsInfo","orderInfo","orderInfos","status","data"));
    }
    //ajax删除订单
    public function ajaxDel(Order $order,Coupon $coupon,$id)
    {
        $orderInfo=$order->where([['id',$id],["f_user_id",session("userInfo")['id']]])->first();
        //判断订单状态是已过期和未付款的（还原优惠券）
        if ($orderInfo->f_order_form_status_id==1||$orderInfo->f_order_form_status_id==3)
        {
            if ($orderInfo->f_coupon_no)
            {
                $couponInfo=$coupon->where("no",$orderInfo->f_coupon_no)->first();
                if ($couponInfo){
                    $couponInfo->f_coupon_status_id=1;
                    $couponInfo->use_time=0;
                    $couponInfo->save();
                }
            }
        }
        if($order->where([['id',$id],["f_user_id",session("userInfo")['id']]])->update(["f_order_form_status_id"=>9])){
            return json(200);
        }
        return json(404,"fail");
    }
    //催单
    public function reminder(Order $order,$id){
        $orderInfo=$order->where("id",$id)->first();
        if (!$orderInfo){
            return json(404,"催单失败","fail");
        }
        if ($orderInfo->f_order_form_status_id!=2){
            return json(404,"催单失败","fail");
        }
        if($orderInfo->update(["is_reminder"=>time()])){
            return json(200,"催单成功");
        }
        return json(404,"催单失败","fail");
    }
    //签收
    public function signIn(Order $order,$id)
    {
        $orderInfo=$order->where("id",$id)->first();
        if (!$orderInfo){
            return json(404,"签收失败","fail");
        }
        if (($orderInfo->f_order_form_status_id!=4)&&($orderInfo->f_order_form_status_id!=5)){
            return json(404,"签收失败1","fail");
        }
        if($orderInfo->update(["f_order_form_status_id"=>14])){
            return json(200,"签收成功");
        }
        return json(404,"签收失败","fail");
    }
    //订单详情
    public function info(Order $order,NormsCombo $normsCombo,Norms $norms,GoodsImg $goodsImg,$no,$type,Custom $custom)
    {
        $orderInfo=$order::with('orderGoods',"orderFormStatus")->where([["f_user_id",session("userInfo")['id']],['no',$no]])->whereNotIn("f_order_form_status_id",[9])->first()->toArray();
        foreach ($orderInfo['order_goods'] as $k=>$v)
        {
            $norms_name=$norms::select(DB::raw('GROUP_CONCAT(name) as name' ))->whereIn("id",explode(",",$v['f_norms_id']))->first()->toArray()['name'];
            $norm_names=trim($norms_name,",");
            $normsComboInfo=$normsCombo->getGoodsInfo($norms,$goodsImg,$v["f_goods_id"],$v["f_norms_id"]);
            $orderInfo['order_goods'][$k]['info']=$normsComboInfo;
            $orderInfo['order_goods'][$k]['info']['name']=$norm_names;
            if($v['f_custom_id'] !== 0){
                $orderInfo["order_goods"][$k]['custom_name']=$custom->where("id",$v["f_custom_id"])->value("hotel_name");
            }
        }

        if ($type==1){
            $index="order";
        }else{
            $index="comment";
        }
        //dd($orderInfo);
        return view("home.order.info",compact("index","orderInfo"));
    }
}
