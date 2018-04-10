<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PushRequest;
use App\Model\Push;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UmengPusher\Umeng\Facades\Umeng;

class PushController extends Controller
{
    //推送列表
    public function index(Push $push)
    {
        $pushInfo=$push::all()->toArray();
        return view("admin.push.index",compact("pushInfo"));
    }
    //添加推送
    public function create()
    {
        return view("admin.push.create");
    }
    //处理添加
    public function add(Request $request,Push $push)
    {
        $type=$request->input("type");
        switch ($type){
            case 0:
                //新闻url推送
                $data['message']=$request->input("message1");
                $data['title']=$request->input("title1");
                $data['description']=$request->input("description1");
                $data['news_url']=$request->input("news_url");
                $data['create_time']=time();
                $data['type']=$type;
                //安卓
                $predefined=['ticker'=>"{$data['message']}",'title'=>"{$data['title']}","text"=>"{$data['description']}","after_open"=>"go_activity","activity"=>"com.yiyousu.yiyousu.ui.NewsActivity"];
                $custom=["url"=>"{$data['news_url']}","title"=>"{$data['title']}"];
                $res=Umeng::android()->sendBroadcast($predefined,$custom);
                $data['ios_res']=json_encode($res);
                //ios
                $predefined2=["alert"=>"{$data['message']}",'badge'=>1];
                $custom2=['type'=>"web","titles"=>"{$data['title']}","desc"=>"{$data['description']}","protocols"=>"noLogin|noStoryBoard|messageWebVC||url-{$data['news_url']}|heightss-0|title-{$data['title']}"];
                $res2=Umeng::ios()->sendBroadcast($predefined2,$custom2);
                $data['android_res']=json_encode($res2);
                break;
            case 1:
                //商品推送
                $data['message']=$request->input("message2");
                $data['title']=$request->input("title2");
                $data['description']=$request->input("description2");
                $data['custom_id']=$request->input("custom_id2");
                $data['create_time']=time();
                $data['type']=$type;
                //安卓
                $predefined=['ticker'=>"{$data['message']}",'title'=>"{$data['title']}","text"=>"{$data['description']}","after_open"=>"go_activity","activity"=>"com.yiyousu.yiyousu.ui.GoodsDetailsActivity"];
                $custom=['id'=>"{$data['custom_id']}","f_area_id"=>1];
                $res=Umeng::android()->sendBroadcast($predefined,$custom);
                $data['ios_res']=json_encode($res);
                //ios
                $predefined2=["alert"=>"{$data['message']}",'badge'=>1];
                $custom2=['type'=>"other","titles"=>"{$data['title']}","desc"=>"{$data['description']}","protocols"=>"noLogin|noStoryBoard|ClassifyDetailViewController||detailId-{$data['custom_id']}"];
                $res2=Umeng::ios()->sendBroadcast($predefined2,$custom2);
                $data['android_res']=json_encode($res2);
                break;
            case 2:
                $data['message']=$request->input("message3");
                $data['title']=$request->input("title3");
                $data['description']=$request->input("description3");
                $data['custom_id']=$request->input("custom_id3");
                $data['category_title']=$request->input("category_title3");
                $data['create_time']=time();
                $data['type']=$type;
                //安卓
                $predefined=['ticker'=>"{$data['message']}",'title'=>"{$data['title']}","text"=>"{$data['description']}","after_open"=>"go_activity","activity"=>"com.yiyousu.yiyousu.ui.RootClassifyActivity"];
                $custom=['id'=>"{$data['custom_id']}","f_area_id"=>1,"title"=>"{$data['category_title']}"];
                $res=Umeng::android()->sendBroadcast($predefined,$custom);
                $data['ios_res']=json_encode($res);
                //ios
                $predefined2=["alert"=>"{$data['message']}",'badge'=>1];
                $custom2=['type'=>"other","titles"=>"{$data['title']}","desc"=>"{$data['description']}","protocols"=>"noLogin|noStoryBoard|goodsClassifyVC||ids-{$data['custom_id']}|titles-{$data['category_title']}"];
                $res2=Umeng::ios()->sendBroadcast($predefined2,$custom2);
                $data['android_res']=json_encode($res2);
                break;
        }
        if($push->create($data))
        {
            return redirect()->route("push.list");
        }
    }
    //修改推送
    public function edit()
    {
        return view("admin.push.edit");
    }
    //处理修改
    public function update()
    {

    }
    //删除推送
    public function delete()
    {

    }
}
