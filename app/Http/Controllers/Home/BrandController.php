<?php

namespace App\Http\Controllers\Home;

use App\Model\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    //加载连锁品牌
    public function index(GoodsType $goodsType,$index="0")
    {
        $hotelInfo=$goodsType->getAllHotel($index);
        return view("home.brand.index",compact("hotelInfo","index"));
    }
}
