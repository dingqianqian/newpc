<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    //
    protected $table="role_access";
    public $timestamps=false;
    protected $guarded=["id"];
}
