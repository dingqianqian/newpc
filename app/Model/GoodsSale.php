<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsSale extends Model
{
    //
    protected $table="goods_sale";
    public $timestamps=false;
    protected $guarded=["id"];
    /*
     * 关联商品表
     */
    public function goods()
    {
        return $this->hasOne("App\Model\Goods","id","f_goods_id");
    }
}
