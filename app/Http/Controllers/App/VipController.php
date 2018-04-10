<?php

namespace App\Http\Controllers\App;

use App\Model\RechargeType;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VipController extends Controller
{
    //
    public function explain(User $user,RechargeType $rechargeType,$id)
    {
        //用户信息
        $userInfo=$user::find($id)->toArray();
        //充值信息
        $rechargeTypeInfo=$rechargeType::where("is_show",0)->orderBy("sort")->get()->toArray();
        return view("app.vip.index",compact("userInfo","rechargeTypeInfo"));
    }
}
