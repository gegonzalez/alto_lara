<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        User::create([
          'name' => 'gegonzalez',
          'email' => 'gegonzalez@gmail.com',
          'password' => bcrypt('1234'),
          'department' => 'Sistemas',
          'type' => '0',
          'user' => 'gegonzalez',
          'proveedor' => '0'
        ]);
    }
}
