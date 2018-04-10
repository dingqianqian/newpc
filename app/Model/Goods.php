<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //
    public $timestamps=false;
    protected $table="goods";
    protected $guarded=["id"];
    /**
     * 通过where条件获取数据
     * @param $where array() 二维数组
     * @return mixed 模型对象
     */
    public function getByWhere($where)
    {
        return $this->where($where)->get();
    }

    /**
     * whereIn查询
     * @param $filed 字段名
     * @param $where array 数组
     * @return mixed 模型对象
     */
    public function getByWhereIn($filed,$where)
    {
        return $this->whereIn($filed,$where)->get();
    }

    /**
     * 获取关联模型关联商品状态表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goodsStatus()
    {
        return $this->belongsTo("App\Model\GoodsStatus","f_goods_status_id");
    }

    /**
     * 商品表关联规格表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function normsCombo()
    {
        return $this->hasMany("App\Model\NormsCombo","f_goods_id");
    }

    /**
     * 商品图片关联表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goodsImg()
    {
        return $this->hasMany("App\Model\GoodsImg","f_goods_id");
    }
    /*
     * 关联商品类型
     */
    public function goodsType()
    {
        return $this->belongsTo("App\Model\GoodsType","f_goods_type_id");
    }
    /*
     * 关联订单商品表
     */
    public function orderGoods()
    {
        return $this->hasMany("App\Model\OrderGoods","id","f_goods_id");
    }
    /*
     * 关联商品详情图
     */
    public function goodsDetailsImg()
    {
        return $this->hasOne("App\Model\GoodsDetailsImg","f_goods_id","id");
    }
}
