<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddValueTax extends Model
{
    //
    protected $table="add_value_tax";
    public $timestamps=false;
    protected $guarded=["id"];
    /*
     * 关联用户表
     */
    public function user()
    {
        return $this->hasOne("App\Model\User","id","f_user_id");
    }
}
