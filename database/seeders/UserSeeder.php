<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@school.test'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('password'), // ganti dengan password yang aman
            ]
        );
        $admin->assignRole('admin');

        // Writer user
        $writer = User::firstOrCreate(
            ['email' => 'writer@school.test'],
            [
                'name' => 'News Writer',
                'username' => 'writer',
                'password' => Hash::make('password'),
            ]
        );
        $writer->assignRole('writer');

        // Principal user
        $principal = User::firstOrCreate(
            ['email' => 'principal@school.test'],
            [
                'name' => 'School Principal',
                'username' => 'kepalasekolah',
                'password' => Hash::make('password'),
            ]
        );
        $principal->assignRole('principal');

        // Student user
        $student = User::firstOrCreate(
            ['email' => 'student@school.test'],
            [
                'name' => 'Sample Student',
                'username' => 'siswa',
                'password' => Hash::make('password'),
            ]
        );
        $student->assignRole('student');
    }
}
