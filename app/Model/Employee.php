<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    public $timestamps=false;
    protected $table="employee";
    protected $guarded=['id'];
    //关联部门表
    public function department()
    {
        return $this->belongsTo("App\Model\Department","f_department_id");
    }
    //关联员工状态表
    public function employeeStatus()
    {
        return $this->belongsTo("App\Model\EmployeeStatus","f_employee_status_id");
    }
    //关联地区表
    public function area()
    {
        return $this->belongsTo("App\Model\Area","f_area_id");
    }
    //关联用户表
    public function user()
    {
        return $this->hasMany("App\Model\User","f_employee_id");
    }
}
