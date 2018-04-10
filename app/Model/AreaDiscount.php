<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AreaDiscount extends Model
{
    protected $table = "area_discount";
    protected $guarded = [];
    public $timestamps = false;

    //关联地区表(area2)
    public function area()
    {
       return $this->hasOne("App\Model\Area","id","f_area_id");
    }
}
