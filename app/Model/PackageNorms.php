<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PackageNorms extends Model
{
    protected $table = "package_norms";
    protected $guarded = ["id"];
    public $timestamps = false;
}
