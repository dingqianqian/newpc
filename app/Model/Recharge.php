<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    //
    protected $table="recharge";
    public $timestamps=false;
    protected $guarded=["id"];
    /*
     * 关联支付类型表
     */
    public function payType()
    {
        return $this->belongsTo("App\Model\PayType","f_pay_type_id","id");
    }
    /**
     * 关联用户表
     */
    public function user()
    {
        return $this->belongsTo("App\Model\User","f_user_id","id");
    }
}
