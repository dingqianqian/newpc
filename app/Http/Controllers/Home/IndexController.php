<?php

namespace App\Http\Controllers\Home;

use App\Model\Area;
use App\Model\Goods;
use App\Model\News;
use App\Model\NormsCombo;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    /**
     * 首页数据
     * @param Goods $goods
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Goods $goods,NormsCombo $normsCombo,News $news,Area $area){
        //酒店专区
        if (Cache::has("hotel"))
        {
            $hotel=Cache::get("hotel");
        }else{
            $hotel['kfjz']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[563,567,645,646,647,649])->get()->toArray();
            $hotel['kfyp']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[570,810,811,812,813,814])->get()->toArray();
            $hotel['qjyp']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[571,573,576,578,651,697])->get()->toArray();
            $hotel['dqzq']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[624,653,654])->get()->toArray();
            $hotel['zzbc']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[601,602,604,606,655])->get()->toArray();
            $hotel['ycyp']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[612,613,614,615])->get()->toArray();
            $hotel['bcxd']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[])->get()->toArray();
            $hotel['srdz']=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[1004])->get()->toArray();
            Cache::put("hotel",$hotel,60);
        }
        //居家专区
        if (Cache::has("home"))
        {
            $home=Cache::get("home");
        }else
            {
                $home["jjyz"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[794,708,709,710,712,713])->get()->toArray();
                $home["zzjf"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[730])->get()->toArray();
                $home["qjyp"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[776,797,798,799,801,802])->get()->toArray();
                $home["jjzx"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[])->get()->toArray();
                $home["xhzq"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[715,718,719,723,725,729])->get()->toArray();
                Cache::put("home",$home,60);
            }
        //饭店专区
        if (Cache::has("house"))
        {
            $house=Cache::get("house");
        }else
            {
                $house["ctyz"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[626,661,662,663,664,665])->get()->toArray();
                $house["ctyp"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[658,659,680,681,688,695])->get()->toArray();
                $house["qjyp"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[629,631,632,633,635,667])->get()->toArray();
                $house["cfyp"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[637,669,670,672,676,683])->get()->toArray();
                $house["zzbc"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[])->get()->toArray();
                $house["zxzq"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[])->get()->toArray();
                $house["bcxd"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[])->get()->toArray();
                $house["srdz"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[1003])->get()->toArray();
                Cache::put("house",$house,60);
            }
        //定制专区
        if (Cache::has("custom"))
        {
            $custom=Cache::get("custom");
        }else
            {
                $custom["qtlx"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[958,959])->get()->toArray();
                $custom["sblx"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[898,900])->get()->toArray();
                $custom["csbj"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[837])->get()->toArray();
                $custom["glht"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[963,964,965,968])->get()->toArray();
                $custom["dfsd"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[929])->get()->toArray();
                $custom["htkj"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[973,992])->get()->toArray();
                $custom["jhbg"]=$goods->where("f_goods_status_id","!=",5)->whereIn("id",[883,884])->get()->toArray();
                Cache::put('custom',$custom,60);
            }
        //获取热卖推荐
        $goodsInfo=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->whereIn("id",[563,647,645,629])->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            $goodsInfo[$k]["image_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);
        }
        //获取首页公告
        $newsInfo=$news::where("id",">",21)->orderBy("id","desc")->get()->toArray();
        //获取用户ip地址
        $res=file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip={$_SERVER['REMOTE_ADDR']}");
        $res=json_decode($res,true);
        if ($res['code']==0)
        {
            $city=mb_substr($res['data']['city'],0,2);
            $cityId=$area::where("name","like","%{$city}%")->first();
            if ($cityId)
            {
                $cityIds=$cityId->id;
            }else{
                $cityIds=1;
            }
            session(["f_area_id"=>$cityIds]);
        }else
            {
                session(["f_area_id"=>1]);
            }
        return view("home.index.index",compact("hotel","home","house","custom","goodsInfo","newsInfo"));
    }
}
