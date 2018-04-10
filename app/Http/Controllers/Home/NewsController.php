<?php

namespace App\Http\Controllers\Home;

use App\Model\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    //新闻展示页面
    public function index($id)
    {
        return view("home.new.news$id");
    }
    //新闻列表页面
    public function lists(News $news)
    {
        $newsInfo=$news::where("id",">",21)->orderBy("id","desc")->get()->toArray();
        return view("home.new.list",compact("newsInfo"));
    }
    //手机端新闻展示页面
    public function mobile(News $news,$id)
    {
        $newsInfo=$news::find($id)->toArray();
        return view("home.new.mobile",compact("newsInfo"));
    }
    //pc端展示页面
    public function pc(News $news,$id)
    {
        $newsInfo=$news::find($id)->toArray();
        return view("home.new.pc",compact("newsInfo"));
    }
}
