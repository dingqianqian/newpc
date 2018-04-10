<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $table="coupon";
    public $timestamps=false;
    protected $guarded=["id"];
    /*
    * 关联优惠券类型
    */
    public function couponType()
    {
        return $this->belongsTo("App\Model\CouponType","f_coupon_type_id","id");
    }
    /*
   * 关联用户表
   */
    public function user()
    {
        return $this->belongsTo("App\Model\User","f_user_id","id");
    }
    /*
     * 关联地区表
     */
    public function area()
    {
        return $this->hasOne("App\Model\Area","id","f_area_id");
    }
}
