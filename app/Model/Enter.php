<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Enter extends Model
{
    protected $table="enter";
    protected $guarded=["id"];
    public $timestamps=false;

    //关联用户表
    public function user()
    {
        return $this->belongsTo("App\Model\User","f_user_id","id");
    }
    //关联入驻图片表
    public function enterImage()
    {
        return $this->belongsTo("App\Model\EnterImage","id","f_enter_id");
    }
    //关联入驻信息表
    public function enterMessage()
    {
        return $this->hasOne("App\Model\EnterMessage","f_enter_id","id");
    }
}
