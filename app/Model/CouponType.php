<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponType extends Model
{
    //
    public $timestamps=false;
    protected $table="coupon_type";
    protected $guarded=["id"];

    //关联优惠券状态表
    public function couponStatus(){
        return $this->belongsTo("App\Model\CouponStatus","f_coupon_type_status_id","id");
    }
}
