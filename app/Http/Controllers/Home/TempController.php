<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TempController extends Controller
{
    //
    public function info()
    {
        return view("home.temp.info");
    }
    public function vip()
    {
        return view("home.temp.vip");
    }
}
