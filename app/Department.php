<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $primaryKey = 'dept_no';

    public $incrementing = false;

    public function managers()
    {
        return $this->belongsToMany(Employee::class, 'dept_manager', 'dept_no', 'emp_no');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'dept_emp', 'dept_no', 'emp_no');
    }
}
