<?php


namespace App;


use App\Salary;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
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
}
