<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
	//
	protected $table="custom";
	public $timestamps=false;
	protected $guarded=["id"];
    //获取用户的定制信息
	public function getAll($f_user_id)
	{
		return $this->where([["f_user_id",$f_user_id],['is_delete',0]])->orderBy("id","desc")->get()->toArray();
	}
	//关联用户表
    public function user()
    {
        return $this->belongsTo("App\Model\User","f_user_id","id");
    }
}
