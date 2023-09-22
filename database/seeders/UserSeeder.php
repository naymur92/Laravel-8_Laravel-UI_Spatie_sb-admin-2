<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = User::create([
      'name' => 'SuperAdmin',
      'email' => 'admin@gmail.com',
      'password' => bcrypt('admin123456'),
      'type' => 1,
      'status' => 1,
      'created_by' => 1
    ]);
    $role = Role::findOrFail(1);
    $user->assignRole([$role->name]);
  }
}
