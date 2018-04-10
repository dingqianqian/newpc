<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CouponTypeRequest;
use App\Model\CouponStatus;
use App\Model\CouponType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoupontypeController extends Controller
{
    //优惠券列表
    public function index(CouponType $couponType,Request $request){
        $couponTypeInfo = $couponType::with("CouponStatus")->get()->toArray();
        return view('admin.coupontype.index',compact('couponTypeInfo'));
    }
    //添加优惠券
    public function create(CouponStatus $couponStatus,Request $request){
        $couponStatusInfo = $couponStatus::select('id','name')->get()->toArray();
        return view('admin.coupontype.create',compact("couponStatusInfo"));
    }
    //处理添加
    public function add(CouponTypeRequest $request,CouponType $couponType){
        $data = $request->except('_token','expire_time_start','expire_time_end');
        $data['expire_time_start'] = $request->input('expire_time_start');  //获取有效期起点
        $data['expire_time_start'] = getTimeStamp($data['expire_time_start']); //去掉年月日
        $data['expire_time_start'] = strtotime($data['expire_time_start']);   //时间戳
        $data['expire_time_end'] = $request->input('expire_time_end');      //获取有效期终点
        $data['expire_time_end'] = getTimeStamp($data['expire_time_end']);
        $data['expire_time_end'] = strtotime($data['expire_time_end']);
        if ($couponType->create($data)){
            return redirect()->route('coupontype.list')->with(['msg'=>'添加成功']);
        }else{
            return back()->with(['msg'=>'添加失败']);
        }
    }
    //修改优惠券
    public function edit(CouponStatus $couponStatus,CouponType $couponType,Request $request,$id){
        $couponStatusInfo = $couponStatus::select('id','name')->get()->toArray(); //优惠券状态
        $couponTypeInfo = $couponType::find($id)->toArray();    //修改者的信息
        return view('admin.coupontype.edit',compact("couponStatusInfo","couponTypeInfo"));
    }
    //处理修改
    public function update(CouponType $couponType,Request $request,$id){
        $data = $request->except('_token','expire_time_start','expire_time_end');
        $data['expire_time_start'] = $request->input('expire_time_start');  //获取有效期起点
        $data['expire_time_start'] = getTimeStamp($data['expire_time_start']);
        $data['expire_time_start'] = strtotime($data['expire_time_start']);
        $data['expire_time_end'] = $request->input('expire_time_end');      //获取有效期终点
        $data['expire_time_end'] = getTimeStamp($data['expire_time_end']);
        $data['expire_time_end'] = strtotime($data['expire_time_end']);
        if ($couponType::find($id)->update($data)){
            return redirect()->route('coupontype.list')->with(['msg'=>'编辑成功']);
        }else{
            return back()->with(['msg'=>'编辑失败']);
        }
    }
    //删除优惠券
    public function delete(CouponType $couponType,$id){
        if ($couponType::find($id)->delete()){
//            return redirect()->route('coupontype.list')->with(['msg'=>'删除成功']);
            return json(200,"删除成功");
        }else{
            return back()->with(['msg'=>'删除失败']);
        }
    }
}
