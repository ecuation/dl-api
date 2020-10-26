<?php


namespace API;


use App\Department;
use App\Employee;
use Carbon\Carbon;

class EmployeeControllerTest extends \TestCase
{
    public function mockDepartments()
    {
        $customer_serv_department = Department::create([
            'dept_no' => 'd009',
            'dept_name' => 'Customer Services'
        ]);
        $development_department = Department::create([
            'dept_no' => 'd005',
            'dept_name' => 'Development'
        ]);
        $finance_department = Department::create([
            'dept_no' => 'd002',
            'dept_name' => 'Finance'
        ]);
    }

    public function mockEmployees()
    {
        $employee = factory(\App\Employee::class)->create();
        $employee->departmentsEmployees()->attach('d009', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);
        $employee->departmentsEmployees()->attach('d005', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);

        //dd($employee->departmentsEmployees->pluck('dept_name'));
    }

    public function mockManagers()
    {
        $employee = factory(\App\Employee::class)->create();
        $employee->departmentsMangers()->attach('d005', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);
        $employee->departmentsMangers()->attach('d002', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);

        dd($employee->departmentsMangers->pluck('dept_name'));
    }

    public function testSearchEmployees()
    {
        $response = $this->createMainUser();
        $this->mockDepartments();
        $this->mockEmployees();
        $this->mockManagers();
    }
}
