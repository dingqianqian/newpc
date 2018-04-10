<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NormsGroup extends Model
{
    //
    protected $table='norms_group';
    public $timestamps=false;
    public $guarded = [];
    //获取单个商品的group类型
    public function getNormsGroup($id)
    {
        return $this->whereIn('id',$id)->select()->get()->toArray();
    }
    //关联属性表
    public function norms()
    {
        return $this->hasMany("App\Model\Norms","f_norms_group_id");
    }
}
