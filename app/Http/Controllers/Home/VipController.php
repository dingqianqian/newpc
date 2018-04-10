<?php

namespace App\Http\Controllers\Home;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VipController extends Controller
{
    //
    public function index(User $user)
    {
        $index="vip";
        $level=$user::find(session("userInfo")['id'])->f_vip_level_id;
        if ($level==1)
        {
         return view("home.vip.norm",compact("index"));
        }
        return view("home.vip.vip",compact("index"));
    }
}
