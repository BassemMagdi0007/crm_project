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
        User::truncate();
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 0,
            'password'=> Hash::make('123'),
        ]);
        User::create([
            'name' => 'employee',
            'email' => 'employee@admin.com',
            'role' => 1,
            'password'=> Hash::make('123'),
        ]);
        User::create([
            'name' => 'employee',
            'email' => 'customer@employee.com',
            'role' => 2,
            'password'=> Hash::make('123'),
        ]);
    }
}
