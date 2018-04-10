<?php

namespace App\Http\Controllers\Home;

use App\Model\Collection;
use App\Model\Goods;
use App\Model\GoodsSale;
use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyListController extends Controller
{
    //常购清单页面
    public function index(Collection $collection,GoodsSale $goodsSale,Goods $goods,NormsCombo $normsCombo)
    {
        $goodsSaleInfo=$goodsSale->where("f_user_id",session("userInfo")["id"])->get()->toArray();
        $count["jdyp"]=0;
        $count["fdyp"]=0;
        $count["lspp"]=0;
        if (!$goodsSaleInfo)
        {
            $goodsInfos=[];
        }else{
            foreach ($goodsSaleInfo as $k=>$v)
            {
                $arr[$v['f_goods_id']][]=$v;
                $goodsID[]=$v['f_goods_id'];
            }
            $goodsInfo=$goods::with(['goodsImg'=>function($query){
                $query->where("is_lead","T");
            }])->whereIn("id",array_unique($goodsID))->where("f_goods_status_id","!=",5)->get()->toArray();
            foreach ($goodsInfo as $k=>$v)
            {
                if ($v["f_goods_status_id"]==5)
                {
                    continue;
                }
                $goodsInfos[]=$v;
            }
            foreach ($goodsInfos as $k=>$v)
            {
                if (isset($v["goods_img"][0]["name"])){
                    $goodsInfos[$k]["name_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);

                }else{
                    $goodsInfos[$k]["name_url"]="";
                }
                $goodsInfos[$k]["count"]=count($arr[$v['id']]);
                $flag=$collection->where([["f_user_id",session("userInfo")['id']],["f_goods_id",$v["id"]]])->first();
                if ($flag)
                {
                    $goodsInfos[$k]["is_collection"]=true;
                }else{
                    $goodsInfos[$k]["is_collection"]=false;
                }
                if (in_array($v['f_goods_type_id'],[5,6,7,10,149,9,160]))
                {
                    $count["jdyp"]++;
                }
                if (in_array($v['f_goods_type_id'],[11,12,13,161,14,153,162]))
                {
                    $count["fdyp"]++;
                }
                if(!in_array($v['f_goods_type_id'],[52,53,164,158,54,11,12,13,161,14,153,162,5,6,7,10,149,9,160]))
                {
                    $count["lspp"]++;
                }
            }
            $goodsInfos=multi_array_sort($goodsInfos,"count",SORT_DESC);
        }
        $index="buylist";
        return view("home.buylist.index",compact("index","goodsInfos","count"));
    }
}
