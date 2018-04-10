<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EnterImage extends Model
{
    protected $table = "enter_image";
    protected $guarded = ['id'];
    public $timestamps=false;
}
