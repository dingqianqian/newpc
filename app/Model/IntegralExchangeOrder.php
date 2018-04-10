<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IntegralExchangeOrder extends Model
{
    //
    protected $table="integral_exchange_order";
    protected $guarded=["id"];
    public $timestamps=false;
}
