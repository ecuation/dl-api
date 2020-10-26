<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->employee_first_name . ' ' . $this->employee_last_name,
            'first_name' => $this->employee_first_name,
            'last_name' => $this->employee_last_name,
            'employee_no' => $this->employee_no,
            'employee_hire_date' => $this->employee_hire_date,
            'salaries' => $this->salaries,
            'titles' => $this->titles
        ];
    }
}
