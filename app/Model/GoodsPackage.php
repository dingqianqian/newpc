<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsPackage extends Model
{
    protected $table = "goods_package";
    protected $guarded = ["id"];
    public $timestamps = false;
}
