<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $librarianRole = Role::where('name', 'librarian')->first();
        $studentRole = Role::where('name', 'student')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@gmail.com'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@gmail.com',
            'password' => bcrypt('librarian@gmail.com'),
            'role_id' => $librarianRole->id,
        ]);

        User::create([
            'name'=> 'Student User',
            'email'=> 'student@gmail.com',
            'password'=> bcrypt('student@gmail.com'),
            'role_id'=> $studentRole->id,
        ]);

    }
}
