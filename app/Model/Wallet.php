<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $table="wallet";
    public $timestamps=false;
    protected $guarded=["id"];
    //添加钱包记录
    public function add($userId,$number,$explain,$no="",$status=2)
    {
        $data["f_user_id"]=$userId;
        $data["no"]=$no;
        $data["number"]=$number;
        $data["create_time"]=time();
        $data["f_order_form_status_id"]=$status;
        $data["explain"]=$explain;
        $this->create($data);
        return true;
    }
}
