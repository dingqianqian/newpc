<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class NormsCombo extends Model
{
    //
    public $timestamps=false;
    protected $table="norms_combo";
    protected $guarded=["id"];

    /**
     * 关联商品表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo("App\Model\Goods","f_goods_id");
    }

    /**
     * 获取单个规格组合和商品的所有信息
     * @param $norms
     * @param $goodsImg
     * @param $goodsId
     * @param $normsId
     * @param int $areaId
     * @return array
     */
    public function getGoodsInfo($norms,$goodsImg,$goodsId,$normsId,$areaId=1)
    {

        $goodsInfo=$this::with("goods")->where([["f_goods_id",$goodsId],["f_area_id",$areaId],["f_norms_id","$normsId"]])->first();
        if (!$goodsInfo)
        {
            $goodsInfo=$this::with("goods")->where([["f_goods_id",$goodsId],["f_area_id",1],["f_norms_id","$normsId"]])->first();
        }
        if (!$goodsInfo)
        {
            return ["err"=>404,"msg"=>"商品不存在"];
        }
        $goodsInfo=$goodsInfo->toArray();
        //获取规格组合名字
        $NormsCombo=explode(",",$goodsInfo['f_norms_id']);
        $goodsInfo["norms_name"]=$norms->whereIn("id",$NormsCombo)->orderBy("f_norms_group_id")->get()->toArray();
        //获取规格组合的图片信息
        $goodsImgInfo=$goodsImg->where("id",$goodsInfo["f_goods_img_id"])->first();
        $goodsImgInfo=$goodsImgInfo?$goodsImgInfo->toArray():[];
        //生成缓存
        if ($goodsImgInfo){
            $goodsImgInfo["name_url"]=$this->setCache($goodsImgInfo["name"]);
            $goodsImgInfo["thumb_url"]=$this->setCache($goodsImgInfo["thumb"]);
        }else{
            $goodsImgInfo["name_url"]="";
            $goodsImgInfo["thumb_url"]="";
        }
        $goodsInfo["goodsImgInfo"]=$goodsImgInfo;
        return $goodsInfo;
    }
    /**
     * 生成缓存
     */
    public function setCache($name)
    {
        if (Cache::has($name))
        {
            return Cache::get($name);
        }else
            {
                Cache::put($name,getUcloud(env("KOCKET"),$name),60*24*365);
                return Cache::get($name);
            }
    }
    /*
     * 关联商品图片表
     */
    public function goodsImg()
    {
        return $this->hasOne("App\Model\GoodsImg","id","f_goods_img_id");
    }
    /**
     * 关联地区表
     */
    public function area()
    {
        return $this->hasOne("App\Model\Area","id","f_area_id");
    }
}
