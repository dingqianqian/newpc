<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model
{
    //
    protected $table="goods_type";
    public $timestamps=false;
    protected $guarded=["id"];
    //获取所有酒店
    public function getAllHotel($index)
    {
        if ($index)
        {
            return $this->where("index",$index)->get()->toArray();
        }else
            {
                return $this->where("index","!=","0")->get()->toArray();
            }
    }
}
