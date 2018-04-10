<?php

namespace App\Jobs;

use App\Model\AreaDiscount;
use App\Model\NormsCombo;
use App\Model\RelationNormsComboGoodsImg;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NormsComboArea implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $area;
    protected $normsImg;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$area,$normsImg)
    {
        //
        $this->data=$data;
        $this->area=$area;
        $this->normsImg=$normsImg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NormsCombo $normsCombo,AreaDiscount $areaDiscount,RelationNormsComboGoodsImg $relationNormsComboGoodsImg)
    {
        //
        $areaDiscountInfo=$areaDiscount::all()->toArray();
        $discount=[];
        foreach ($areaDiscountInfo as $k=>$v)
        {
            $discount[$v['f_area_id']]=$v['discount'];
        }
        foreach ($this->area as $k=>$v)
        {
            $data=$this->data;
            $data['f_area_id']=$v['id'];
            $data['discount']=$discount[$v['id']];
            $data['single_price']=round($data['single_price']*$discount[$v['id']],2);
            $data['sale_single_price']=round($data['sale_single_price']*$discount[$v['id']],2);
            $piecePrice=round(floatval($data['piece_price'])*$discount[$v['id']],2).preg_replace("/[0-9\.]/",'',$data['piece_price']);
            $data['piece_price']=$piecePrice;
            $smallPiecePrice=round(floatval($data['small_piece_price'])*$discount[$v['id']],2).preg_replace("/[0-9\.]/",'',$data['small_piece_price']);
            $data['small_piece_price']=$smallPiecePrice;
            $normsComboInfo=$normsCombo->create($data);
            foreach ($this->normsImg as $k=>$v)
            {
                $temp['f_norms_combo_id']=$normsComboInfo->id;
                $temp['f_goods_img_id']=$v;
                $relationNormsComboGoodsImg->create($temp);
            }
        }
    }
}
