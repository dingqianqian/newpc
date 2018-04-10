<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PactController extends Controller
{
    //法律首页
    public function law()
    {
        return view("home.law.index");
    }
    //条款首页
    public function clause()
    {
        return view("home.law.clause");
    }
}
