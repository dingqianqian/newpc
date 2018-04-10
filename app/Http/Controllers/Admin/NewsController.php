<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsRequest;
use App\Model\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Tests\NewRequest;

class NewsController extends Controller
{
    //新闻列表页面
    public function index(News $news,Request $request)
    {
        $info['min_time']=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info['max_time']=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['name']=$request->input("name")?$request->input("name"):"";
        $newsInfos=$news->where([["add_time",">=",$info['min_time']],["add_time","<=",$info['max_time']],["title","like","%{$info['name']}%"]])->paginate(15);
        $newsInfo=$newsInfos->toArray();
        $info['min_time']=date("Y年m月d日",$info['min_time']);
        $info['max_time']=date("Y年m月d日",$info['max_time']);
        return view("admin.news.index",compact("newsInfos","newsInfo","info"));
    }
    //添加新闻
    public function create()
    {
        return view("admin.news.create");
    }
    //执行添加
    public function add(NewsRequest $request,News $news)
    {
        $data=$request->only(["title","content","description","authour","type"]);
        if ($request->file("image_url"))
        {
            $data['image_url']=asset($this->uploadImage("news",$request->file("image_url")));
        }else{
            $data['image_url']=url("/");
        }
        $data['small_image_url']=asset($this->uploadImage("news",$request->file("small_image_url")));
        $data['url']=url("newsPc");
        $data['mobile_url']=url("newsPhone");
        $data['add_time']=time();
        $newsInfo=$news->create($data);
        return redirect()->route("news.list")->with(["msg"=>"添加成功"]);

    }
    //删除新闻
    public function delete(News $news,$id)
    {
        $news::destroy($id);
        return json(200,"删除成功");
    }
    //编辑新闻
    public function edit(News $news,$id)
    {
        $newsInfo=$news::find($id)->toArray();
        return view("admin.news.edit",compact("newsInfo"));
    }
    //编辑新闻
    public function update(News $news,$id,Request $request)
    {
        $data=$request->only(["title","content","description","authour","type"]);
        if ($request->file("image_url"))
        {
            $data['image_url']=asset($this->uploadImage("news",$request->file("image_url")));
        }
        if ($request->file("small_image_url"))
        {
            $data['small_image_url']=asset($this->uploadImage("news",$request->file("small_image_url")));
        }
        $data['url']=url("newsPc");
        $data['mobile_url']=url("newsPhone");
        $data['update_time']=time();
        $newsInfo=$news::find($id)->update($data);
        return redirect()->route("news.list")->with(["msg"=>"编辑成功"]);
    }
    //新闻详情
    public function info(News $news,$id)
    {
        $newsInfo=$news::find($id)->toArray();
        return view("admin.news.info",compact("newsInfo"));
    }
}
