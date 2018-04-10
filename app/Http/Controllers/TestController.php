<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Home\CouponController;
use App\Jobs\CommentGoods;
use App\Jobs\NormsComboPrice;
use App\Model\Area;
use App\Model\CheckIns;
use App\Model\Goods;
use App\Model\GoodsDetailsImg;
use App\Model\GoodsEvaluate;
use App\Model\GoodsImg;
use App\Model\GoodsType;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\NormsGroup;
use App\Model\Order;
use App\Model\RelationNormsComboGoodsImg;
use App\Model\ShopCart;
use App\Model\User;
use App\Model\Wallet;
use Baidu\LoginService;
use Baidu\ReportService;
use Carbon\Carbon;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Overtrue\Pinyin\Pinyin;
use UmengPusher\Umeng\Facades\Umeng;
use Xujif\UcloudUfileSdk\UfileSdk;
use Yunpian\Sdk\YunpianClient;

class TestController extends Controller
{
    //微信统一下单
    public function test(Application $application,Pinyin $pinyin)
    {
        if (in_array(mb_substr("99优选",0,1),[0,1,2,3,4,5,6,7,8,9]))
        {
            $arr=["零","一","二","三","四","五","六","七","八","九"];
            $insert['index']=strtoupper(mb_substr($pinyin->abbr($arr[mb_substr("99优选",0,1)]),0,1));
        }else{
            $insert['index']=strtoupper(mb_substr($pinyin->abbr("zz"),0,1));
        }
        dd($insert);
    }
    //微信支付回调
    public function back(Order $order,NormsCombo $normsCombo,Goods $goods,Norms $norms,RelationNormsComboGoodsImg $relationNormsComboGoodsImg)
    {

//        dispatch(new NormsComboPrice(2,1));
//        dd(123);
        $orderGoodsInfo=$order::with("orderGoods")->has("user")->where("create_time",">",1504195200)->whereNotIn("f_user_id",[16,104,288,309,324,344,346,354,538,544,574,616,617,643,653,661,712,717,756,890,1053,1078,1079,1100,1117,1155,1170,1246,1255,1272,1364,1396,1406,1764,1841,2062])->whereIn("f_order_form_status_id",[2,4,5,14,15])->get()->toArray();
        foreach ($orderGoodsInfo as $k=>$v)
        {
            foreach ($v['order_goods'] as $k1=>$v1)
            {
                $orderGoodsCount[]=$v1;
            }
        }
        foreach ($orderGoodsCount as $k=>$v)
        {
            //商品名字
            $orderGoodsCount[$k]['goods_name']=$goods::find($v['f_goods_id'])->name;
            //商品规格
            $orderGoodsCount[$k]['norms']=$norms::select(DB::raw('GROUP_CONCAT(name) as name'))->whereIn("id",explode(",",$v['f_norms_id']))->first()->toArray()['name'];
        }
//        dd($orderGoodsCount);
        foreach ($orderGoodsCount as $k=>$v)
        {
            $keys=$v['f_goods_id'].$v['f_norms_id'];
            $temp[$keys][]=$v;
        }
        foreach ($temp as $k=>$v)
        {
            $count['count']=0;
            foreach ($v as $k1=>$v1)
            {
                $count['goods_name']=$v1['goods_name'];
                $count['norms']=$v1['norms'];
                $count['count']+=$v1['number'];
            }
            $tempTwo[]=$count;
        }
        Excel::create('order',function($excel) use ($tempTwo){
            $excel->sheet('order', function($sheet) use ($tempTwo){
                $sheet->rows($tempTwo);
            });
        })->export('xls');
        dd($relationNormsComboGoodsImg->create(["f_norms_combo_id"=>1,"f_goods_img_id"=>2])->toArray());

    }

//    public function make_tree($list,$pk="id",$pid="parent_id",$child="child",$root=0)
//    {
//        $tree = [];
//        $packData = [];
//        foreach ($list as $data)
//        {
//            $packData[$data[$pk]] = $data;
//        }
//        foreach ($packData as $key=>$val)
//        {
//            if($val[$pid] == $root){
//                $tree[]=& $packData[$key];
//            }else{
//                $packData[$val[$pid]][$child][]=& $packData[$key];
//            }
//        }
//        return $tree;
//    }
}
