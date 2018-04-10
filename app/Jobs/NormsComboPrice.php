<?php

namespace App\Jobs;

use App\Model\NormsCombo;
use App\Model\RelationNormsComboGoodsImg;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NormsComboPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $area;
    protected $discount;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($area,$discount)
    {
        //
        $this->area=$area;
        $this->discount=$discount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NormsCombo $normsCombo,RelationNormsComboGoodsImg $relationNormsComboGoodsImg)
    {
        $normsComboInfo=$normsCombo->where("f_area_id",1)->get()->toArray();
        foreach ($normsComboInfo as $k=>$v)
        {
            $v['f_area_id']=$this->area;
            $v['discount']=$this->discount;
            $v['single_price']=round($v['single_price']*$this->discount,2);
            $v['sale_single_price']=round($v['sale_single_price']*$this->discount,2);
            $piecePrice=round(floatval($v['piece_price'])*$this->discount,2).preg_replace("/[0-9\.]/",'',$v['piece_price']);
            $v['piece_price']=$piecePrice;
            $smallPiecePrice=round(floatval($v['small_piece_price'])*$this->discount,2).preg_replace("/[0-9\.]/",'',$v['small_piece_price']);
            $v['small_piece_price']=$smallPiecePrice;
            $tempNormsComboInfo=$normsCombo->where([["f_area_id",$this->area],['f_goods_id',$v['f_goods_id']],['f_norms_id',"{$v['f_norms_id']}"]])->first();
            $relationNormsComboGoodsImgInfo=$relationNormsComboGoodsImg->where("f_norms_combo_id",$v['id'])->get()->toArray();
            unset($v['id']);
            if ($tempNormsComboInfo)
            {
                $tempNormsComboInfo->update($v);
                $relationNormsComboGoodsImg->where("f_norms_combo_id",$tempNormsComboInfo->id)->delete();
                foreach ($relationNormsComboGoodsImgInfo as $k=>$v)
                {
                    $temp['f_norms_combo_id']=$tempNormsComboInfo->id;
                    $temp['f_goods_img_id']=$v['f_goods_img_id'];
                    $relationNormsComboGoodsImg->create($temp);
                }
            }else{
                $normsComboInfoOne=$normsCombo->create($v);
                foreach ($relationNormsComboGoodsImgInfo as $k=>$v)
                {
                    $temp['f_norms_combo_id']=$normsComboInfoOne->id;
                    $temp['f_goods_img_id']=$v['f_goods_img_id'];
                    $relationNormsComboGoodsImg->create($temp);
                }
            }

        }
    }
}
