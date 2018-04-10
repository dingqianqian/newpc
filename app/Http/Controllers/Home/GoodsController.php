<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\ByIdRequest;
use App\Model\BrowseHistory;
use App\Model\Collection;
use App\Model\Custom;
use App\Model\Goods;
use App\Model\GoodsDetailsImg;
use App\Model\GoodsEvaluate;
use App\Model\GoodsImg;
use App\Model\Norms;
use App\Model\NormsCombo;
use App\Model\NormsGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    //商品详情页
    public function index(BrowseHistory $browseHistory,Collection $collection,GoodsEvaluate $goodsEvaluate,GoodsDetailsImg $goodsDetailsImg,Norms $norms,Goods $goods,GoodsImg $goodsImg,NormsCombo $normsCombo,NormsGroup $normsGroup,Custom $custom,$id)
    {
        //判断用户如果登陆了创建浏览历史
        if (session("userInfo"))
        {
            $data["f_user_id"]=session("userInfo")["id"];
            $data["f_goods_id"]=$id;
            $data["create_time"]=time();
            $browseHistoryInfo=$browseHistory->where([["f_user_id",session("userInfo")["id"]],["f_goods_id",$id]])->first();
            if ($browseHistoryInfo)
            {
                $browseHistoryInfo->create_time=time();
                $browseHistoryInfo->save();
            }else
                {
                    $browseHistory->create($data);
                }
        }
        $goodsImgInfo=$goodsImg->getImg($id)->toArray();
        foreach ($goodsImgInfo as $k=>$v)
        {
            $goodsImgInfo[$k]["name_url"]="http://".$normsCombo->setCache($v["name"]);
            $goodsImgInfo[$k]["thumb_url"]="http://".$normsCombo->setCache($v["thumb"]);
        }
        //获取商品信息
        $goodsInfo=$goods::with("goodsType")->where("id",$id)->first();
        if($goodsInfo)
        {
            $goodsInfo=$goodsInfo->toArray();
        }else{
            abort(404);
        }
        //获取用户定制信息
        $customInfo=$custom->getAll(session("userInfo")["id"]);
        $normsComboInfo=$normsCombo->where([["f_goods_id",$id],['f_area_id',1],['f_goods_status_id',1]])->get()->toArray();
        $str="";
        if($goodsInfo["f_goods_type_id"] == 216 || $goodsInfo['f_goods_type_id']== 217 )
        {
            foreach ($normsComboInfo as $k=>$v)
            {
                $normsComboInfo[$k]["norms_name"]=$norms::select(DB::raw('GROUP_CONCAT(name) as name' ))->whereIn("id",explode(",",$v['f_norms_id']))->first()->toArray()['name'];
                $str.=$v["f_norms_id"].",";
            }
            foreach($normsComboInfo as $k1=>$v1){
                $normsComboInfo[$k1]['norms_name']=trim($v1['norms_name'],',');
            }
        }else{
            foreach ($normsComboInfo as $k=>$v)
            {
                //$normsComboInfo[$k]['norms_name']=$norms::select(DB::raw('GROUP_CONCAT(name) as name' ))->whereIn("id",explode(",",$v['f_norms_id']))->first()->toArray()['name'];
                $normsComboInfo[$k]["f_norms_id"]=explode(",",ltrim($v["f_norms_id"],","));
                $str.=$v["f_norms_id"].",";
            }
        }
        $normsComboID=explode(',',rtrim($str,","));
        $normsComboID=array_unique($normsComboID);
//        获取normsGroup
        $normsGroupInfo=$normsGroup->getNormsGroup(explode(',',$goodsInfo["f_norms_group_id"]));
        foreach ($normsGroupInfo as $k=>$v)
        {
            $normsGroupInfo[$k]["norms"]=$norms->where("f_norms_group_id",$v["id"])->whereIn("id",$normsComboID)->get()->toArray();
        }
        //获取热销商品
        $hotGoods=$goods::with(["goodsImg"=>function($query)
        {
            $query->where('is_lead', 'T');
        }])->whereIn("id",[563,567,645,647,649])->get()->toArray();
        foreach ($hotGoods as $k=>$v)
        {
            $hotGoods[$k]["image_url"]=$normsCombo->setCache($v["goods_img"][0]["name"]);
        }
        //获取商品详情图
        $goodsDetailsImgInfo=$goodsDetailsImg->where("f_goods_id",$id)->first();
        if (!$goodsDetailsImgInfo){
            $goodsDetailsImgInfo["name"]=null;
        }else{
            $goodsDetailsImgInfo=$goodsDetailsImgInfo->toArray();
        }
        $goodsDetailsImgInfo["name_url"]=$normsCombo->setCache($goodsDetailsImgInfo["name"]);
        //获取商品评论
        $goodsEvaluateInfo=$goodsEvaluate::with('user')->where("f_goods_id",$id)->orderBy("create_time","desc")->get()->toArray();
        //获取商品评价平均分
        $goodsEvaluateAvg=round($goodsEvaluate->where("f_goods_id",$id)->avg('favor_degree'),1);
        //是否收藏
        if (session("userInfo"))
        {
            $collectionInfo=$collection->where([["f_user_id",session("userInfo")['id']],["f_goods_id",$id]])->first();
            if ($collectionInfo)
            {
                $isCollection=true;
            }else
                {
                    $isCollection=false;
                }
        }else
            {
                $isCollection=false;
            }
            if ($goodsInfo['f_goods_status_id']==5){
                abort(404);
            }
        return view("home.goods.index",compact('goodsImgInfo','goodsInfo',"normsGroupInfo","normsComboInfo","hotGoods","goodsDetailsImgInfo","goodsEvaluateInfo","goodsEvaluateAvg","isCollection","customInfo"));
    }
    //ajax收藏商品
    public function collect(Collection $collection,ByIdRequest $request)
    {
        if (!session("userInfo"))
        {
            return false;
        }
        $id=$request->input("id");
        //判断用户是否收藏
        $collectionInfo=$collection->where([["f_user_id",session("userInfo")['id']],["f_goods_id",$id]])->first();
        if ($collectionInfo)
        {
            //取消收藏
            if($collectionInfo->delete())
            {
                return ["err"=>200,"msg"=>"取消收藏成功"];
            }
        }else
            {
                $data["f_user_id"]=session("userInfo")["id"];
                $data["f_goods_id"]=$id;
                if($collection->create($data))
                {
                    return ["err"=>200,"msg"=>"收藏成功"];
                }
            }
    }
    //商品搜索结果页面
    public function search(Request $request,Goods $goods,NormsCombo $normsCombo){
        $name=$request->input("name");
        if (!$name){
            //获取所有商品
            return back();
        }else{
            $goodsInfo=$goods::with(["goodsImg"=>function($query)
            {
                $query->where('is_lead', 'T');
            }])->where([["f_goods_status_id","!=","5"],["name","like","%$name%"]])->get()->toArray();
            foreach ($goodsInfo as $k=>$v)
            {
                if ($v["goods_img"]){
                    $goodsInfo[$k]["image_url"]="http://".$normsCombo->setCache($v["goods_img"][0]["name"]);
                }else{
                    $goodsInfo[$k]["image_url"]=null;
                }
            }
        }
        return view("home.goods.result",compact("goodsInfo","name"));
    }
}
