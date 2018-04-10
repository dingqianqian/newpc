<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Push extends Model
{
    //
    protected $table="push";
    public $timestamps=false;
    protected $guarded=["id"];
}
