<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    //
    protected $table="access";
    public $timestamps=false;
    protected $guarded=['id'];
}
