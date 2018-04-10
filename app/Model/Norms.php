<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Norms extends Model
{
    //
    protected $table="norms";
    public $timestamps=false;
    protected $guarded=['id'];
    /*
     * 关联商品分类表
     */
    public function goodsType()
    {
        return $this->belongsTo("App\Model\GoodsType","f_goods_type_id","id");
    }
    /*
     * 关联商品规格表
     */
    public function normsGroup()
    {
        return $this->belongsTo("App\Model\NormsGroup","f_norms_group_id","id");
    }
}
