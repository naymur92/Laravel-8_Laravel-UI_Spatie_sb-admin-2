<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Path to the SQL file
    $sqlFile = database_path('role_perm_data.sql');

    // Read the SQL file content
    $sql = file_get_contents($sqlFile);

    // Execute the SQL statements
    DB::unprepared($sql);
  }
}
