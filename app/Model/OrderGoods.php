<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    //
    public $timestamps=false;
    protected $table="order_goods";
    protected $guarded=["id"];
    /*
     * 关联商品表
     */
    public function goods()
    {
        return $this->belongsTo("App\Model\Goods","f_goods_id","id");
    }
    /**
     * 关联订单表
     */
    public function order()
    {
        return $this->belongsTo("App\Model\Order","f_order_form_no","no");
    }
    /**
     * 关联套餐订制表
     */
    public function custom()
    {
        return $this->belongsTo("App\Model\Custom","f_custom_id","id");
    }
}
