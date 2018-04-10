<?php

namespace App\Http\Controllers\Home;

use App\Model\InvoiceTitle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceTitleController extends Controller
{
    //ajax添加发票抬头
    public function ajaxCreate(Request $request,InvoiceTitle $invoiceTitle)
    {
        $data['name']=$request->input("name");
        if (!$data['name'])
        {
            return json(404,"信息不完整","fail");
        }
        $data["f_user_id"]=session("userInfo")["id"];
        if ($invoiceTitle->create($data))
        {
            return json(200,"添加成功");
        }
        return json(500,"未知错误","fail");
    }
    //ajax编辑发票抬头
    public function ajaxUpdate(Request $request,InvoiceTitle $invoiceTitle)
    {
        $invoiceTitleInfo=$invoiceTitle->where([["id",$request->input("id")],["f_user_id",session("userInfo")["id"]]])->first();
        if (!$invoiceTitleInfo)
        {
            return json(404,"发票抬头不存在","fail");
        }
        $invoiceTitleInfo->name=$request->input("name");
        if ($invoiceTitleInfo->save())
        {
            return json(200,"编辑成功");
        }
        return json(500,"未知错误","fail");
    }
    //ajax删除发票抬头
    public function ajaxDel(Request $request,InvoiceTitle $invoiceTitle)
    {
        $id=$request->input("id");
        if ($invoiceTitle->where([["id",$id],["f_user_id",session("userInfo")["id"]]])->delete())
        {
            return json(200,"删除成功");
        }
        return json(500,"未知错误","fail");
    }
}
