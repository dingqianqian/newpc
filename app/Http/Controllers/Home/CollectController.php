<?php

namespace App\Http\Controllers\Home;

use App\Model\Collection;
use App\Model\GoodsEvaluate;
use App\Model\GoodsImg;
use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectController extends Controller
{
    //收藏页面
    public function index(GoodsEvaluate $goodsEvaluate,Collection $collection,GoodsImg $goodsImg,NormsCombo $normsCombo)
    {
        //获取用户全部收藏
        $collectionInfo=$collection::with('goods')->where("f_user_id",session("userInfo")["id"])->get()->toArray();
        $count["jdyp"]=0;
        $count["fdyp"]=0;
        $count["lspp"]=0;
        foreach ($collectionInfo as $k=>$v)
        {
            if ($v['goods']['f_goods_status_id']==5)
            {
                unset($collectionInfo[$k]);
            }else
                {
                    $collectionInfo[$k]["avg"]=$goodsEvaluate->where("f_goods_id",$v["goods"]["id"])->avg('favor_degree')?round($goodsEvaluate->where("f_goods_id",$v["goods"]["id"])->avg('favor_degree'),1):"5.0";
                    $goodsImgInfoTemp=$goodsImg->getMain($v["goods"]["id"]);
                    if ($goodsImgInfoTemp)
                    {
                        $collectionInfo[$k]["name_url"]="http://".$normsCombo->setCache($goodsImgInfoTemp->name);
                    }else
                        {
                            $collectionInfo[$k]["name_url"]="";
                        }
                    if (in_array($v['goods']['f_goods_type_id'],[5,6,7,10,149,9,160]))
                    {
                        $count["jdyp"]++;
                    }
                    if (in_array($v['goods']['f_goods_type_id'],[11,12,13,161,14,153,162]))
                    {
                        $count["fdyp"]++;
                    }
                    if(!in_array($v['goods']["f_goods_type_id"],[52,53,164,158,54,11,12,13,161,14,153,162,5,6,7,10,149,9,160]))
                    {
                        $count["lspp"]++;
                    }
                }
        }
        $index="collect";
        return view("home.collect.index",compact("index","collectionInfo","count"));
    }
}
