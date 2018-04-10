<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PayErrorCount extends Model
{
    //
    protected $table="pay_error_count";
    public $timestamps=false;
    protected $guarded=["id"];
}
