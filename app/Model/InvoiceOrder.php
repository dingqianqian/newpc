<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceOrder extends Model
{
    //
    protected $table="invoice_order";
    protected $guarded=["id"];
    public $timestamps=false;
    /**
     * 关联增值税发票表
     */
    public function addValueTax()
    {
        return $this->belongsTo("App\Model\AddValueTax","f_user_id","f_user_id");
    }
}
