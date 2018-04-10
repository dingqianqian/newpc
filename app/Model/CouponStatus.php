<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponStatus extends Model
{
    //
    public $timestamps=false;
    protected $table="coupon_status";
    protected $guarded=["id"];
}
