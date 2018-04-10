<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table="user";
    public $timestamps=false;
    protected $guarded=["id","wallet","integral","f_vip_level_id","sms_code"];
    //关联员工表
    public function employee()
    {
        return $this->hasOne("App\Model\Employee",'id',"f_employee_id");
    }
    //关联订单表
    public function order()
    {
        return $this->hasMany(Order::class,"f_user_id");
    }
}
