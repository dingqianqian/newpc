<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsEvaluate extends Model
{
    //
    protected $table="goods_evaluate";
    public $timestamps=false;
    protected $guarded=["id"];
    /*
     * 关联用户表
     */
    public function user()
    {
        return $this->belongsTo("App\Model\User","f_user_id");
    }
    /*
     * 关联商品表
     */
    public function goods()
    {
        return $this->belongsTo("App\Model\Goods","f_goods_id");
    }
}
