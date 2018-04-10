<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    //
    protected $table="employee_role";
    public $timestamps=false;
    protected $guarded=["id"];
    /*
     * 关联员工表
     */
    public function employee()
    {
        return $this->hasOne("App\Model\Employee","id","employee_id");
    }
    /**
     * 关联角色表
     */
    public function role()
    {
        return $this->hasOne("App\Model\Role","id","role_id");
    }
}
