<?php


namespace App\Http\Controllers;
use App\Employee;
use App\Http\Resources\EmployeeResource;
use App\Repositories\EmployeeRepo;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmployeeRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $url_query = $request->input();
        $query = $this->repo->search($url_query);
        $employees = $query->employees->paginate(10);

        return EmployeeResource::collection($employees);
    }


    public function getManagers()
    {
        $managers = Employee::managers()->get();
        return EmployeeResource::collection($managers);
    }
}
