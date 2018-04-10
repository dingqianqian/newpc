<?php

namespace App\Http\Controllers\Home;

use App\Model\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Overtrue\LaravelPinyin\Facades\Pinyin;

class AreaController extends Controller
{
    //渲染城市页面
    public function index(Area $area)
    {
        $ids = $area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
        $id = array_unique(explode(",",$ids["ids"]));
        $areaInfo = $area::select("id","name","index")->whereNotIn("id",$id)->get()->groupBy("index")->toArray();
        ksort($areaInfo);
        return view("home.area.index",compact("areaInfo"));
    }
    //返回城市json包
    public function cityJson(Area $area)
    {
        if (Cache::has("allCityJson"))
        {
            $res=Cache::get("allCityJson");
        }else{
            $ids = $area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
            $id = array_unique(explode(",",$ids["ids"]));
            $areaInfo = $area::select("id","name")->whereNotIn("id",$id)->where("id","!=","1")->get()->toArray();
            $city=[];
            foreach ($areaInfo as $k=>$v)
            {
                if (mb_substr($v['name'],-1)=="市"||mb_substr($v['name'],-1)=="省")
                {
                    $pinyin=Pinyin::convert(mb_substr($v['name'],0,-1));
                }else
                {
                    $pinyin=Pinyin::convert($v['name']);
                }
                $str="";
                foreach ($pinyin as $k1=>$v1)
                {
                    $str.=$v1;
                }
                $v['pinyin']=$str;
                $city[]=$v;
            }
            $res=json(200,$city);
            Cache::put("allCityJson",$res,60*24);
        }
        return $res;
    }
    //切换城市
    public function setCity(Area $area,$id)
    {
        $areaInfo=$area::find($id);
        if ($areaInfo)
        {
            $data['name']=$areaInfo['name'];
            $data['id']=$areaInfo['id'];
        }else
            {
                $data['name']="北京";
                $data['id']=1;
            }
        session(["f_area_info"=>$data]);
         return redirect("/");
    }
}
