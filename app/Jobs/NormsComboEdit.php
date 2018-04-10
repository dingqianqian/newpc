<?php

namespace App\Jobs;

use App\Model\Area;
use App\Model\NormsCombo;
use App\Model\RelationNormsComboGoodsImg;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NormsComboEdit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->id=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Area $area,NormsCombo $normsCombo,RelationNormsComboGoodsImg $relationNormsComboGoodsImg)
    {
        //
        $areaInfo=$area::where("id",">","1")->get()->toArray();
        $normsComboOne=$normsCombo::find($this->id['id']);
        $relationNormsComboGoodsImgInfo=$relationNormsComboGoodsImg::where("f_norms_combo_id",$this->id['id'])->get()->toArray();
        foreach ($areaInfo as $k=>$v)
        {
            $normsComboInfo=$normsCombo->where([["f_area_id",$v['id']],["f_goods_id",$normsComboOne->f_goods_id],["f_norms_id",$this->id['f_norms_id']]])->first();
            if ($normsComboInfo)
            {
                $temp=$normsComboOne->toArray();
                $temp['discount']=$normsComboInfo->discount;
                $temp['f_area_id']=$normsComboInfo->f_area_id;
                $temp['single_price']=round($temp['single_price']*$temp['discount'],2);
                $temp['sale_single_price']=round($temp['sale_single_price']*$temp['discount'],2);
                $piecePrice=round(floatval($temp['piece_price'])*$temp['discount'],2).preg_replace("/[0-9\.]/",'',$temp['piece_price']);
                $temp['piece_price']=$piecePrice;
                $smallPiecePrice=round(floatval($temp['small_piece_price'])*$temp['discount'],2).preg_replace("/[0-9\.]/",'',$temp['small_piece_price']);
                $temp['small_piece_price']=$smallPiecePrice;
                $normsComboInfo->update($temp);
                $relationNormsComboGoodsImg->where("f_norms_combo_id",$normsComboInfo->id)->delete();
                foreach ($relationNormsComboGoodsImgInfo as $k=>$v)
                {
                    $temp2['f_norms_combo_id']=$normsComboInfo->id;
                    $temp2['f_goods_img_id']=$v['f_goods_img_id'];
                    $relationNormsComboGoodsImg->create($temp2);
                }
            }
        }
    }
}
