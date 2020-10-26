<?php


namespace API;


use App\Department;
use App\Employee;
use App\OauthClient;
use App\Repositories\EmployeeRepo;
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
        $employeeCustomerServices = factory(\App\Employee::class)->create();
        $employeeCustomerServices->departmentsEmployees()->attach('d009', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);

        $employeeDevelopment = factory(\App\Employee::class)->create([
            'first_name' => 'Bill',
            'last_name' => 'Gates'
        ]);
        $employeeDevelopment->departmentsEmployees()->attach('d005', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);

        $employeeDevelopment = factory(\App\Employee::class)->create([
            'first_name' => 'Steve',
            'last_name' => 'Wozniak'
        ]);
        $employeeDevelopment->departmentsEmployees()->attach('d005', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);
    }

    public function mockManagers()
    {
        $managerCustomerServices = factory(\App\Employee::class)->create();
        $managerCustomerServices->departmentsMangers()->attach('d009', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);

        $managerDevelopment = factory(\App\Employee::class)->create();
        $managerDevelopment->departmentsMangers()->attach('d005', ['from_date' => Carbon::yesterday(), 'to_date' => Carbon::now()]);

        return compact('managerCustomerServices', 'managerDevelopment');

    }

    public function testSearchEmployees()
    {
        $this->createMainUser();
        $this->mockDepartments();
        $this->mockEmployees();
        $managers = $this->mockManagers();
        $oauth_client = OauthClient::find(2);

        $body = [
            'username' => $this->main_user_test['email'],
            'password' => $this->main_user_test['password'],
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'grant_type' => 'password',
            'scope' => '*'
        ];

        $response = $this->json('POST','v1/oauth/token', $body, [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]);

        $decoded_res = json_decode($response->response->getContent());
        $search_response = $this->json('GET', route('employees.index'), ['manager_no' => $managers['managerDevelopment']->emp_no], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $decoded_res->access_token
        ]);

        $search_response->assertResponseStatus(200);

        $decoded_search_res = json_decode($search_response->response->getContent());

        $this->assertEquals($decoded_search_res->meta->total, 2);
    }
}
