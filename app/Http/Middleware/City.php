<?php

namespace App\Http\Middleware;

use App\Model\Area;
use Closure;

class City
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取用户IP设置地区
        if (session("f_area_info")==null)
        {
            $res=file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip={$_SERVER['REMOTE_ADDR']}");
            $res=json_decode($res,true);
            if ($res['code']==0)
            {
                $city=mb_substr($res['data']['city'],0,2);
                $cityId=Area::where("name","like","%{$city}%")->first();
                if ($cityId)
                {
                    $data['name']=$cityId['name'];
                    $data['id']=$cityId['id'];
                }else
                    {
                        $data['name']="北京";
                        $data['id']=1;
                    }
                session(["f_area_info"=>$data]);
            }else
            {
                $data['name']="北京";
                $data['id']=1;
                session(["f_area_info"=>$data]);
            }
        }
        return $next($request);
    }
}
