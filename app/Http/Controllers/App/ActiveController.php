<?php

namespace App\Http\Controllers\app;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActiveController extends Controller
{
    //1.11.21 冰点活动列表
    public function index()
    {
        return view("app.active.index");
    }
}
