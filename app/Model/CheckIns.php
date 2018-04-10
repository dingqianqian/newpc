<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CheckIns extends Model
{
    //
    public $timestamps=false;
    protected $table="check_ins";
    protected $guarded=["id"];
    //访问修饰创建时间
    public function getCreateTimeAttribute($value)
    {
        return date("Ymd",$value);
    }
    //判断某天用户是否签到
    public function isCheckIn($userId,$star,$end)
    {
        $info=$this->where([["f_user_id",$userId],["create_time",">=",$star],["create_time","<=",$end]])->first();
        return $info;
    }
}
