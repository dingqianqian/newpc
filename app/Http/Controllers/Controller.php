<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Yunpian\Sdk\YunpianClient;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /*
     * 发送短信验证码
     */
    public function YunPianCode($phone,$id,$code,$dir)
    {

        if (Storage::exists("$dir/$phone.txt"))
        {
            if (Storage::lastModified("$dir/$phone.txt")+120>time())
            {
                return false;
            }
        }
        $clnt=YunpianClient::create("2489d60e93f19eff2b41ee9a6da75c03");
        $param = [YunpianClient::MOBILE => $phone,YunpianClient::TPL_ID=>"$id",YunpianClient::TPL_VALUE=>"#code#={$code}"];
        $r = $clnt->sms()->tpl_single_send($param);
        return $r;
    }
    /**
     * 上传图片
     */
    public function uploadImage($dir,$file,$type="jpg",$flag=false,$width=350,$height=350)
    {
        if (!file_exists("images/$dir"))
        {
            mkdir("images/$dir",0777,true);
            chmod("images/$dir",0777);
        }
        $goodsImgName=make_rand_str().".$type";
        if ($flag)
        {
            $path=Image::make($file)->resize($height,$width)->encode($type)->save("images/$dir/$goodsImgName")->basename;
        }else{
            $path=Image::make($file)->encode($type)->save("images/$dir/$goodsImgName")->basename;
        }
        return "images/".$dir."/".$path;
    }
}
