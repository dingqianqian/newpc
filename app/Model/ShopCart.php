<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    //
    public $timestamps=false;
    protected $table="cart";
    protected $guarded=["id"];

    /**
     * 关联商品表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function goods()
    {
        return $this->hasOne("App\Model\Goods","id","f_goods_id");
    }

    /**
     * 关联属性表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function normsCombo()
    {
        return $this->hasMany("App\Model\NormsCombo","f_goods_id","f_goods_id");
    }
}
