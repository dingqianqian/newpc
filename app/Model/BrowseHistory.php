<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BrowseHistory extends Model
{
    //
    protected $table="browse_history";
    public $timestamps=false;
    protected $guarded=["id"];
    /*
     * 关联图片表
     */
    public function goodsImg()
    {
        return $this->hasMany('App\Model\GoodsImg',"f_goods_id","f_goods_id");
    }
    /*
     * 关联商品表
     */
    public function goods()
    {
        return $this->hasOne("App\Model\Goods","id","f_goods_id");
    }
}
