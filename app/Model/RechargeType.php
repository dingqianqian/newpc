<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RechargeType extends Model
{
    //
    public $timestamps=false;
    protected $table="recharge_type";
    protected $guarded=["id"];
}
