<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsImg extends Model
{
    //
    protected $table="goods_img";
    public $timestamps=false;
    protected $guarded=['id'];
    //获取商品的图片
    public function getImg($id)
    {
        return $this->where('f_goods_id',$id)->get();
    }
    //获取商品的主图
    public function getMain($id)
    {
        return $this->where([['f_goods_id',$id],["is_lead","T"]])->first();
    }
}
