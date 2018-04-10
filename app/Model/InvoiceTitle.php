<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceTitle extends Model
{
    //
    protected $table="invoice_title";
    public $timestamps=false;
    protected $guarded=["id"];
}
