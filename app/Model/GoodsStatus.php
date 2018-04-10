<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsStatus extends Model
{
    //
    public $timestamps=false;
    protected $table="goods_status";

    /**
     * 关联模型关联商品表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Goods()
    {
        return $this->hasMany("App\Model\Goods","f_goods_status_id","id");
    }
}
