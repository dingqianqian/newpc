<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JoinUsController extends Controller
{
    //
    public function index()
    {
        $index="joinus";
        return view("home.joinus.index",compact("index"));
    }
}
