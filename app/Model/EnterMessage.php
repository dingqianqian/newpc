<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EnterMessage extends Model
{
    protected $table="enter_message";
    protected $guarded=["id"];
    public $timestamps=false;
}
