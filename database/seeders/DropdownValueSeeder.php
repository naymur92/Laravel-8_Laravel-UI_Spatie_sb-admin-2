<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DropdownValueSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Path to the SQL file
    $sqlFile = database_path('dropdown_values.sql');

    // Read the SQL file content
    $sql = file_get_contents($sqlFile);

    // Execute the SQL statements
    DB::unprepared($sql);
  }
}
