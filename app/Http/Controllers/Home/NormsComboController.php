<?php

namespace App\Http\Controllers\Home;

use App\Model\NormsCombo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NormsComboController extends Controller
{
    //获取sku信息
    public function getInfo(Request $request,NormsCombo $normsCombo)
    {
        $id=$request->input("id");
        $norms=$request->input("norms");
        $normsComboInfo=$normsCombo::with('goodsImg')->where([["f_goods_id",$id],["f_norms_id",$norms],['f_area_id',session("f_area_info")['id']]])->first();
        if (!$normsComboInfo)
        {
            $normsComboInfo=$normsCombo::with('goodsImg')->where([["f_goods_id",$id],["f_norms_id",$norms],['f_area_id',1]])->first();
        }
        $data["price"]=number_format($normsComboInfo->single_price,2,".","");
        $data["small_price"]=number_format($normsComboInfo->sale_single_price,2,".","");
        $data["piece_price"]=is_11121()?$normsComboInfo->small_piece_price:$normsComboInfo->piece_price;
        if (!$normsComboInfo->goodsImg){
            $data['thumb_url']=null;
        }else{
            $data["thumb_url"]="http://".$normsCombo->setCache($normsComboInfo->goodsImg->thumb);
        }

        if (!$normsComboInfo->goodsImg){
            $data["name_url"]=null;
        }else{
            $data["name_url"]="http://".$normsCombo->setCache($normsComboInfo->goodsImg->name);
        }
        $data["sale_stock"]=$normsComboInfo->sale_stock>99?99:$normsComboInfo->sale_stock;
        if (is_11121())
        {
            $data["flag"]=1;
        }else
            {
                $data["flag"]=0;
            }
        return $data;
    }
}
