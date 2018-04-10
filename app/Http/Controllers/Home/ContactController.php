<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    //联系我们
    public function index()
    {
        return view("home.contact.index");
    }
    //个人中心联系我们
    public function person()
    {
        $index="contact";
        return view("home.contact.contact",compact("index"));
    }
}
