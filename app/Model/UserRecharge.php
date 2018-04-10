<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRecharge extends Model
{
    //
    protected $table="user_recharge";
    public $timestamps=false;
    protected $guarded=["id"];
}
