<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TakeOver extends Model
{
    //
    protected $table="take_over_addr";
    public $timestamps=false;
    protected $guarded=['id'];
    /*
     * 获取用户收货地址默认收货地址放在第一位
     */
    public  function getAll($f_user_id)
    {
        return $this->where("f_user_id",$f_user_id)->orderBy("is_default","desc")->get()->toArray();
    }
}
