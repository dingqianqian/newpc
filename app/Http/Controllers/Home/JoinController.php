<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JoinController extends Controller
{
    //
    public function index()
    {
        $index="join";
        return view("home.join.index",compact("index"));
    }
}
