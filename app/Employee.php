<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    //use QueryCacheable;
    protected $cacheFor = 180;

    protected $table = 'employees';

    protected $primaryKey = 'emp_no';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'hire_date',
        'birth_date',
    ];

    protected $dates = [
        'hire_date',
        'birth_date'
    ];


    //public $incrementing = false;

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'emp_no', 'emp_no');
    }

    public function departmentsEmployees() {
        return $this->belongsToMany(Department::class, 'dept_emp', 'emp_no', 'dept_no');
    }

    public function departmentsMangers() {
        return $this->belongsToMany(Department::class, 'dept_manager', 'emp_no', 'dept_no');
    }

    public function titles()
    {
        return $this->hasMany(Title::class, 'emp_no');
    }

    public function scopeManagers($query) {
        $query->select(
            DB::raw('employees.first_name as employee_first_name'),
            DB::raw('employees.last_name as employee_last_name'),
            DB::raw('employees.emp_no as employee_no'),
            DB::raw('employees.hire_date as employee_hire_date')
        )->join('dept_manager', 'dept_manager.emp_no', '=', 'employees.emp_no')
            ->distinct('employees.emp_no')
            ->orderBy('employee_hire_date', 'ASC');
    }
}
