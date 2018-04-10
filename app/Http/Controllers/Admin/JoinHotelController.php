<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JoinHotelRequest;
use App\Model\JoinHotel;
use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Xujif\UcloudUfileSdk\UfileSdk;
use Intervention\Image\Facades\Image;

class JoinHotelController extends Controller
{
    //加盟列表
    public function index(JoinHotel $joinHotel,Request $request,NormsCombo $normsCombo)
    {
        $info["name"] = $request->input("name")?$request->input("name"):"";
        $info["type"] = $request->input("type");
        if ($info["type"]===null||$info["type"]==2)
        {
            $info["type"] = [0,1];
        }else{
            $info["type"] = [$request->input("type")];
        }
        $joinHotelInfos = $joinHotel->where("name","like","%{$info["name"]}%")->whereIn("type",$info["type"])->paginate(15);
        $joinHotelInfo = $joinHotelInfos->toArray();
        foreach ($joinHotelInfo["data"] as $k=>$v)
        {
            $joinHotelInfo["data"][$k]["logo_url"] = "http://".$normsCombo->setCache($v["image_url"]);
        }
        if(count($info["type"]) == 1)
        {
            $info["type"] = $request->input("type");
        }else{
            $info["type"] = 2;
        }
        return view("admin.joinHotel.index",compact("joinHotelInfos","joinHotelInfo","info"));
    }
    //添加加盟酒店
    public function create()
    {
        return view("admin.joinHotel.create");
    }
    //处理添加
    public function add(JoinHotelRequest $request,JoinHotel $joinHotel)
    {
        $data = $request->except("_token","image_url");
        $ufile=new UfileSdk(env("KOCKET"),"WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==","2ee9865d56c51fe23890983e69811e3139c73029");
        if (!file_exists("public/hotel"))
        {
            mkdir("public/hotel",0777,true);
            chmod("public/hotel",0777);
        }
        $imageUrl=make_rand_str().".jpg";
        $imageUrl=Image::make($request->file("image_url"))->encode('jpg')->save("public/hotel/$imageUrl")->basename;
        $ufile->putFile($imageUrl,"public/hotel/$imageUrl");
        $data["image_url"] = $imageUrl;
        if($joinHotel->create($data))
        {
            return redirect()->route("joinHotel.list")->with(["msg"=>"添加成功"]);
        }
    }
    //修改加盟酒店
    public function edit(JoinHotel $joinHotel,$id)
    {
        $joinHotelInfo = $joinHotel->where("id",$id)->first()->toArray();
        return view("admin.joinHotel.edit",compact("joinHotelInfo"));
    }
    //处理修改
    public function update(JoinHotel $joinHotel,Request $request,$id)
    {
        $data = $request->except("_token","image_url");
        //实例化类
        $ufile=new UfileSdk(env("KOCKET"),"WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==","2ee9865d56c51fe23890983e69811e3139c73029");
        //判断文件是否上传
        if($request->file("image_url"))
        {
            if (!file_exists("public/hotel"))
            {
                mkdir("public/hotel",0777,true);
                chmod("public/hotel",0777);
            }
            $imageUrl=make_rand_str().".jpg";
            $imageUrl=Image::make($request->file("image_url"))->encode('jpg')->save("public/hotel/$imageUrl")->basename;
            $ufile->putFile($imageUrl,"public/hotel/$imageUrl");
            $data["image_url"] = $imageUrl;
        }
        if($joinHotel::find($id)->update($data))
        {
            return redirect()->route("joinHotel.list")->with(["msg"=>"修改成功"]);
        }

    }
    //删除加盟酒店
    public function delete(JoinHotel $joinHotel,$id)
    {
        $joinHotelInfo = $joinHotel::find($id)->delete();
        if($joinHotelInfo)
        {
            return json(200,"删除成功");
        }
    }
}
