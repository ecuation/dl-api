<?php

namespace App\Repositories;


use App\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeRepo
{
    public $employees;

    CONST SEARCH_METHODS = [
        'dateFrom' => 'searchByDateFrom',
        'dateTo' => 'searchByDateTo',
        'manager_no' => 'searchByManager',
    ];

    public function __construct()
    {
        $this->employees = Employee::select(
            DB::raw('employees.first_name as employee_first_name'),
            DB::raw('employees.last_name as employee_last_name'),
            DB::raw('employees.emp_no as employee_no'),
            DB::raw('employees.hire_date as employee_hire_date'),
            DB::raw('dept_manager.emp_no as manager_emp_no')
        )->join('dept_emp', 'dept_emp.emp_no', '=', 'employees.emp_no')
            ->join('dept_manager', 'dept_manager.dept_no', '=', 'dept_emp.dept_no')
            ->groupBy('employees.emp_no')
            ->orderBy('employee_hire_date', 'ASC');
    }

    public function search($input = []) {
        foreach ($input as $index => $value) {
            if(isset(self::SEARCH_METHODS[$index])) {
                $this->{self::SEARCH_METHODS[$index]}($value);
            }
        }

        return $this;
    }

    public function searchByDateFrom($searchDateFrom)
    {
        $searchDateFrom = Carbon::createFromTimestamp(strtotime($searchDateFrom));
        $searchDateFrom->setTimeFromTimeString("00:00:00");

        return $this->employees->where('employees.hire_date', '>=', $searchDateFrom);
    }

    public function searchByDateTo($searchDateTo)
    {
        $searchDateTo = Carbon::createFromTimestamp(strtotime($searchDateTo));
        $searchDateTo->setTimeFromTimeString("23:59:59");

        return $this->employees->where('employees.hire_date', '<=', $searchDateTo);
    }

    public function searchByManager($managerId)
    {
        $this->employees
            ->where('dept_manager.emp_no', '=', $managerId)
            ->where('employees.emp_no', '<>', $managerId);
    }
}
