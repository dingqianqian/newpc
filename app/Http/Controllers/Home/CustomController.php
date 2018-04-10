<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\ByIdRequest;
use App\Http\Requests\CustomRequest;
use App\Model\Custom;
use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Xujif\UcloudUfileSdk\UfileSdk;

class CustomController extends Controller
{
    //展示定制信息页面
    public function index(Custom $custom,NormsCombo $normsCombo){
        $customInfo=$custom->where([["f_user_id",session("userInfo")["id"]],['is_delete',0]])->orderBy("id","desc")->get()->toArray();
        foreach($customInfo as $k=>$v){
            if($v['logo']){
                $customInfo[$k]["img_info"]="http://".$normsCombo->setCache($v['logo']);
            }else{
                $customInfo[$k]["img_info"]="";
            }
        }
        $index="custom";
        return view("home.custom.index",compact("index","customInfo"));
    }

    //添加定制信息
    public function addCustom(CustomRequest $request,Custom $custom)
    {
      $area_name=$request->input("area_name");
      $phone_name=$request->input("phone_name");
      $data['hotel_phone']=$area_name."-".$phone_name;
      $data['hotel_name']=$request->input("hotel_name");
      $data['hotel_address']=$request->input("hotel_address");
      $data['create_time']=time();
      $data['f_user_id']=session("userInfo")["id"];
      if ($request->file("logo"))
      {
          if (!file_exists("images/custom"))
          {
              mkdir("images/custom",0777,true);
              chmod("images/custom",0777);
          }
          $ufile= new UfileSdk(env("KOCKET"), "WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==", "2ee9865d56c51fe23890983e69811e3139c73029");
          $detailsName=make_rand_str().".jpg";
          $detailsName=Image::make($request->file("logo"))->encode('jpg')->save("images/custom/$detailsName")->basename;
          $ufile->putFile($detailsName,"images/custom/$detailsName");
          $data['logo']=$detailsName;
      }else {
          $data['logo'] = '';
      }
        if($custom_data= $custom->create($data)){
            return back();
        }else
        {
            return back();
        }
    }
    //删除定制信息
    public function delCustom(Request $request,Custom $custom)
    {
       $id=$request->input("id");
       $data=['is_delete'=>1];
       $info=$custom->where([["id",$id],["f_user_id",session("userInfo")["id"]]])->update($data);
       if($info){
           return ["err"=>200,"msg"=>"删除成功"];
       }else
       {
           return ["err"=>500,"msg"=>"删除失败"];
       }
    }
    //修改定制信息
    public function updCustom(CustomRequest $request,Custom $custom)
    {
        $id = $request->input("id");
        $info['is_delete']=1;
        $data['sort']=$custom->where([["f_user_id",session("userInfo")['id']],["id",$id]])->value("sort");
        $area_name=$request->input("area_name");
        $phone_name=$request->input("phone_name");
        $data['hotel_phone']=$area_name."-".$phone_name;
        $data['hotel_name']=$request->input("hotel_name");
        $data['hotel_address']=$request->input("hotel_address");
        $data['create_time'] = time();
        $data['f_user_id'] = session("userInfo")["id"];
        if ($request->file("logo")) {
            if (!file_exists("images/custom")) {
                mkdir("images/custom", 0777, true);
                chmod("images/custom", 0777);
            }
            $ufile = new UfileSdk(env("KOCKET"), "WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==", "2ee9865d56c51fe23890983e69811e3139c73029");
            $detailsName = make_rand_str() . ".jpg";
            $detailsName = Image::make($request->file("logo"))->encode('jpg')->save("images/custom/$detailsName")->basename;
            $ufile->putFile($detailsName, "images/custom/$detailsName");
            $data['logo'] = $detailsName;
        }else{
            $data['logo']=$custom->where([["f_user_id",session("userInfo")['id']],["id",$id]])->value("logo");
        }
        $customInfo = $custom->where([["f_user_id", session("userInfo")['id']], ['id', $id]])->update($info);
        if ($custom_data = $custom->create($data)) {
            return redirect("custom/index")->with(["msg" => "修改成功"]);
        } else {
            return redirect("custom/index")->with(["msg" => "修改失败"]);
        }

    }
    //选定定制信息
    public  function chooseCustom(Request $request,Custom $custom,NormsCombo $normsCombo)
    {
        $id=$request->input("id");
       // dd($id);
        $customInfo=$custom->where([['f_user_id',session('userInfo')['id']],["id",$id]])->first();
        if($customInfo['logo']){
                $customInfo["img_info"]="http://".$normsCombo->setCache($customInfo['logo']);
        }else{
                $customInfo["img_info"]="";
        }
        if($customInfo){
            return ["err" => 200,"msg"=>$customInfo, "选择成功"];
        }else{
            return ["err" => 500, "选择失败"];
        }
    }

}
