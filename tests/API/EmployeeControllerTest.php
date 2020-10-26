<?php


namespace API;


use App\Department;
use Carbon\Carbon;
use Faker\Factory;

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
        $this->mockCustomerServicesEmployees();
        $this->mockDevelopmentEmployees();
    }

    public function mockCustomerServicesEmployees()
    {
        $faker = Factory::create();
        $employeeCustomerServices = factory(\App\Employee::class)->create();
        $employeeCustomerServices->departmentsEmployees()->attach('d009', [
            'from_date' => Carbon::yesterday(),
            'to_date' => Carbon::now()
        ]);

        foreach (range(1, 100) as $item)
        {
            $employeeCustomerServices = factory(\App\Employee::class)->create();
            $employeeCustomerServices->departmentsEmployees()->attach('d009',
                ['from_date' => $faker->dateTimeBetween('-5 years'),
                    'to_date' => $faker->dateTimeBetween('- years')
                ]);
        }
    }

    public function mockDevelopmentEmployees()
    {
        $faker = Factory::create();
        $employeeDevelopment = factory(\App\Employee::class)->create([
            'first_name' => 'Bill',
            'last_name' => 'Gates'
        ]);
        $employeeDevelopment->departmentsEmployees()
            ->attach('d005', [
                'from_date' => $faker->dateTimeBetween('-5 years'),
                'to_date' => $faker->dateTimeBetween('-1 years')
            ]);

        $employeeDevelopment = factory(\App\Employee::class)->create([
            'first_name' => 'Steve',
            'last_name' => 'Wozniak'
        ]);
        $employeeDevelopment->departmentsEmployees()
            ->attach('d005', [
                'from_date' => $faker->dateTimeBetween('-5 years'),
                'to_date' => $faker->dateTimeBetween('-1 years')
            ]);

        $employeeDevelopment = factory(\App\Employee::class)->create([
            'first_name' => 'Terry',
            'last_name' => 'Bogard'
        ]);
        $employeeDevelopment->departmentsEmployees()
            ->attach('d005', [
                'from_date' => $faker->dateTimeBetween('-5 years'),
                'to_date' => $faker->dateTimeBetween('-1 years')
            ]);
    }

    public function mockManagers()
    {
        $managerCustomerServices = factory(\App\Employee::class)->create([
            'first_name' => 'Manager 1'
        ]);
        $customerServicesDepartment = Department::where('dept_name', 'Customer Services')->first();
        $managerCustomerServices->departmentsMangers()
            ->attach($customerServicesDepartment->dept_no, [
                'from_date' => Carbon::yesterday(),
                'to_date' => Carbon::now()
            ]);

        $managerDevelopment = factory(\App\Employee::class)->create([
            'first_name' => 'Manager 2'
        ]);
        $developmentDepartment = Department::where('dept_name', 'Development')->first();
        $managerDevelopment->departmentsMangers()
            ->attach($developmentDepartment->dept_no, [
                'from_date' => Carbon::yesterday(),
                'to_date' => Carbon::now()
            ]);

        return compact('managerCustomerServices', 'managerDevelopment');
    }

    public function testSearchEmployees()
    {
        $main_user = $this->createMainUser();
        $this->mockDepartments();
        $this->mockEmployees();
        $managers = $this->mockManagers();

        $search_response = $this->json(
            'GET',
            route('employees.index'), [
                'manager_no' => $managers['managerDevelopment']->emp_no
            ], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $main_user['token']
        ]);

        $search_response->assertResponseStatus(200);
        $decoded_search_res = json_decode($search_response->response->getContent());
        $users = collect($decoded_search_res->data)->pluck(['last_name'])->toArray();
        $this->assertEquals(count(array_diff($users, ['Gates', 'Wozniak', 'Bogard'])), 0);
        $this->assertEquals($decoded_search_res->meta->total, 3);
    }


    public function testGetManagers()
    {
        $main_user = $this->createMainUser();
        $this->mockDepartments();
        $this->mockEmployees();
        $managers = $this->mockManagers();

        $manager_response = $this->json(
            'GET',
            route('employees.getManagers'), [], [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $main_user['token']
            ]);

        $manager_response->assertResponseStatus(200);
        $decoded_managers_res = json_decode($manager_response->response->getContent());
        $users = collect($decoded_managers_res->data)->pluck(['first_name'])->toArray();

        $this->assertEquals(count(array_diff($users, ['Manager 1', 'Manager 2'])), 0);
    }
}
