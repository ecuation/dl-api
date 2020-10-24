<?php
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Schema;

class EmployeesSQLSeeder extends Seeder
{
    public function run()
    {
        /*Schema::disableForeignKeyConstraints();
        foreach (glob("database/db_dump/*.dump") as $filename) {
            $sql = file_get_contents($filename);
            DB::unprepared($sql);
        }
        Schema::enableForeignKeyConstraints();*/

        /*$sql = file_get_contents('database/db_dump/load_departments.dump');
        DB::statement($sql);

        $sql = file_get_contents('database/db_dump/load_employees.dump');
        DB::statement($sql);

        $sql = file_get_contents('database/db_dump/load_dept_emp.dump');
        DB::statement($sql);

        $sql = file_get_contents('database/db_dump/load_dept_manager.dump');
        DB::statement($sql);

        $sql = file_get_contents('database/db_dump/load_titles.dump');
        DB::statement($sql);

        $sql = file_get_contents('database/db_dump/load_salaries1.dump');
        DB::statement($sql);

        $sql = file_get_contents('database/db_dump/load_salaries2.dump');
        DB::statement($sql);

        $sql = file_get_contents('database/db_dump/load_salaries3.dump');
        DB::statement($sql);*/


        $sql = file_get_contents('database/db_dump/employees.sql');
        DB::unprepared($sql);
    }
}
