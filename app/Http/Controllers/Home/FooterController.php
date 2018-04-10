<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FooterController extends Controller
{
    //购物流程
    public function shop()
    {
        return view("home.footer.shop");
    }
    //关于我们
    public function about()
    {
        return view("home.footer.about");
    }
    //发票流程
    public function invoice()
    {
        return view("home.footer.invoice");
    }
    //退换货流程
    public function returnSale()
    {
        return view("home.footer.returnSale");
    }
    //退换货政策
    public function returnPolicy()
    {
        return view("home.footer.returnPolicy");
    }
    //退款说明
    public function refund()
    {
        return view("home.footer.refund");
    }
}
