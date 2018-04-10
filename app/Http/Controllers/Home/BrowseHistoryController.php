<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\ByIdRequest;
use App\Model\BrowseHistory;
use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BrowseHistoryController extends Controller
{
    //浏览历史展示页
    public function index(BrowseHistory $browseHistory,NormsCombo $normsCombo)
    {
        $browseHistoryInfo=$browseHistory::with(['goodsImg'=>function($query){
            $query->where("is_lead","T");
        },'goods'])->where([["f_user_id",session("userInfo")['id']],["create_time","<=",time()],["create_time",">=",time()-3600*24*30]])->select("*",DB::raw("FROM_UNIXTIME(create_time,'%Y-%m-%d') as time"))->orderBy("create_time","desc")->get()->toArray();
        $count["jdyp"]=0;
        $count["fdyp"]=0;
        $count["lspp"]=0;
        if ($browseHistoryInfo){
            $browseHistoryInfos=[];
            foreach ($browseHistoryInfo as $k=>$v)
            {
                if (!$v['goods_img']){
                    $v["goods_img"][0]["name"]=null;
                }
                $v["name_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);
                $browseHistoryInfos[$v["time"]][]=$v;
            }
            $hotel=[];
            $house=[];
            $home=[];
            foreach ($browseHistoryInfos as $k=>$v)
            {
                foreach ($v as $k1=>$v1)
                {
                    if ($v1["goods"]["f_goods_status_id"]==5)
                    {
                        unset($v[$k1]);
                    }else{
                        if (in_array($v1["goods"]['f_goods_type_id'],[5,6,7,10,149,9,160]))
                        {
                            $count["jdyp"]++;
                            $hotel[$k][]=$v1;
                        }
                        if (in_array($v1["goods"]['f_goods_type_id'],[11,12,13,161,14,153,162]))
                        {
                            $count["fdyp"]++;
                            $house[$k][]=$v1;
                        }
                        if(!in_array($v1['goods']["f_goods_type_id"],[52,53,164,158,54,11,12,13,161,14,153,162,5,6,7,10,149,9,160]))
                        {
                            $count["lspp"]++;
                            $home[$k][]=$v1;
                        }
                    }
                }
            }
        }else{
            $browseHistoryInfos=[];
            $hotel=[];
            $house=[];
            $home=[];
        }
        $index="browse";
        return view("home.browseHistory.index",compact("index","browseHistoryInfos","count","hotel","house","home"));
    }
    //根据id删除历史
    public function delById(ByIdRequest $request,BrowseHistory $browseHistory)
    {
        $id=$request->input("id");
        if($browseHistory->where([["id",$id],["f_user_id",session("userInfo")["id"]]])->delete())
        {
            return ["err"=>200,"msg"=>"删除成功"];
        }else
            {
                return ["err"=>400,"msg"=>"删除错误"];
            }
    }
    //根据时间删除历史
    public function delByTime(Request $request,BrowseHistory $browseHistory)
    {
        $time=$request->input("time");
        $star=strtotime($time);
        $end=$star+3600*24;
        if($browseHistory->where([["create_time","<",$end],["create_time",">",$star],["f_user_id",session("userInfo")["id"]]])->delete())
        {
            return ["err"=>200,"msg"=>"删除成功"];
        }else
        {
            return ["err"=>400,"msg"=>"删除错误"];
        }
    }
}
