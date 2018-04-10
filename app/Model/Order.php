<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table="order_form";
    public $timestamps=false;
    protected $guarded=["id"];
    //和订单商品表关联
    public function orderGoods()
    {
        return $this->hasMany("App\Model\OrderGoods","f_order_form_no","no");
    }
    //获取可开发票订单
    public function getInvoiceOrder($userId)
    {
        return $this::with("payType")->where([["create_time",">=",strtotime(date("Y-m"))],["is_need_invoice",0],["is_fixed_invoice",0],["f_user_id",$userId]])->whereIn("f_order_form_status_id",[2,4,5,14,15])->get()->toArray();
    }
    //关联订单状态表
    public function orderFormStatus()
    {
        return $this->belongsTo("App\Model\OrderFormStatus","f_order_form_status_id","id");
    }
    /*
     * 关联支付方式
     */
    public function payType()
    {
        return $this->hasOne("App\Model\PayType","id","f_pay_type_id");
    }
    /*
     * 关联优惠卷
     */
    public function coupon()
    {
        return $this->hasOne("App\Model\Coupon","no","f_coupon_no");
    }
    /*
     * 关联地区
     */
    public function area()
    {
        return $this->hasOne("App\Model\Area","id","f_area_id");
    }
    /*
     * 关联用户表
     */
    public function user()
    {
        return  $this->belongsTo("App\Model\User","f_user_id",'id');
    }
}
