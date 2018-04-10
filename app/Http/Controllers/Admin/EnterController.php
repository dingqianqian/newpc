<?php

namespace App\Http\Controllers\Admin;

use App\Model\Custom;
use App\Model\Enter;
use App\Model\EnterImage;
use App\Model\EnterMessage;
use App\Model\GoodsType;
use App\Model\NormsCombo;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Overtrue\Pinyin\Pinyin;

class EnterController extends Controller
{
    //入驻列表
    public function index(Enter $enter,Request $request,NormsCombo $normsCombo,User $user,EnterMessage $enterMessage)
    {
        //搜索的值
        $info["phone"] = $request->input("phone")?$request->input("phone"):"";
        $info["status"] = $request->input("status");
        //判断状态 数组
        if($info["status"] === null || $info["status"]==4)
        {
            $info["status"] = [0,1,2];
        }else{
            $info["status"] = [$request->input("status")];
        }
        //过滤测试人员手机号
        $userId = [];
        if ($info['phone']) {
            $userIds = $user->where("signin_name", "like", "%{$info['phone']}%")->whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        } else {
            $userIds = $user->select("id")->whereNotIn("signin_name", employeePhone())->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        }
        //数据库查询
        $enterInfos = $enter::with("user")->whereIn("f_user_id",$userId)->whereIn("status",$info["status"])->paginate(15);
        $enterInfo = $enterInfos->toArray();
        foreach ($enterInfo["data"] as $k=>$v)
        {
            $enterInfo["data"][$k]["logo_url"] = "http://".$normsCombo->setCache($v["logo"]);
        }
        if(count($info["status"]) == 1){
            $info["status"] = $request->input("status");
        }else{
            $info["status"] = 4;
        }
        return view("admin.enter.index",compact("enterInfos","enterInfo","info"));
    }
    //入驻详情
    public function info(Enter $enter,EnterImage $enterImage,NormsCombo $normsCombo,EnterMessage $enterMessage,$id)
    {
        //入驻信息
        $enterInfo = $enter::with("enterMessage","user","enterImage")->where("id",$id)->first()->toArray();
        //入驻图片信息
        $enterImageInfo = $enterImage->where("f_enter_id",$id)->get()->toArray();
        foreach ($enterImageInfo as $k=>$v)
        {
          $enterImageInfo[$k]["image_url"] = "http://".$normsCombo->setCache($v["image"]);
        }
        return view("admin.enter.info",compact("enterInfo","enterImageInfo"));
    }
    //审核状态修改
    public function status(Enter $enter,EnterMessage $enterMessage,NormsCombo $normsCombo,GoodsType $goodsType,Pinyin $pinyin,$enterId,$id)
    {
        //添加数据到enterMessage表
        $data["f_enter_id"] = $enterId;
        $data["is_read"] = 0;
        $enterMessageInfo = $enterMessage->create($data);
        //修改状态
        $enterInfo = $enter->where("id",$enterId)->first();
        if(!$enterInfo)
        {
            return json(404,"该入驻信息不存在");
        }
        //标记为已通过
        if($enterInfo->status==0&&$id==1)
        {
            $enterInfo->status = 1;
            $enterInfo->save();
            $insert['name']=$enterInfo->name;
            $insert['parent_id']=56;
            if (in_array(mb_substr($enterInfo->name,0,1),[0,1,2,3,4,5,6,7,8,9]))
            {
                $arr=["零","一","二","三","四","五","六","七","八","九"];
                $insert['index']=strtoupper(mb_substr($pinyin->abbr($arr[mb_substr($enterInfo->name,0,1)]),0,1));
            }else{
                $insert['index']=strtoupper(mb_substr($pinyin->abbr($enterInfo->name),0,1));
            }
            $insert['type']=$enterInfo->type;
            if ($goodsTypeInfoId=$goodsType->create($insert)->id)
            {
                file_put_contents("/data/www/default/Public/HotelWineshopCooperationImg/$goodsTypeInfoId.png",file_get_contents("http://".$normsCombo->setCache($enterInfo->logo)));
            }
            return json(200,"标记为已通过成功");
        }
        //标记为已驳回
        if($enterInfo->status==0&&$id==2)
        {
            $enterInfo->status = 2;
            $enterInfo->save();
            return json(200,"标记为已驳回成功");
        }
    }
}
