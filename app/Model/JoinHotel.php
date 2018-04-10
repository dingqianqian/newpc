<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JoinHotel extends Model
{
    protected $table="join_hotel";
    public $timestamps=false;
    protected $guarded=["id"];
}
