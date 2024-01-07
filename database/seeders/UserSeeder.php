<?php

namespace Database\Seeders;

use App\Constants\GenderConstants;
use App\Constants\User\RoleConstants;
use App\Constants\User\UserTypeConstants;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'user_type_id' => UserTypeConstants::SYSTEM_USER,
                'role_id' => RoleConstants::ADMIN,
                'gender_id' => GenderConstants::MALE,
                'firstname' => 'Mustafa',
                'lastname' => 'Güner',
                'email' => 'mguner@ciu.edu.tr',
                'username' => 'mguner',
                'phone_no' => '05321234566',
                'date_of_birth' => '1999-09-28',
                'password' => bcrypt('asdf1234'),
                'created_at' => now(),
            ],
            [
                'user_type_id' => UserTypeConstants::DOCTOR,
                'role_id' => RoleConstants::USER,
                'gender_id' => GenderConstants::MALE,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'doe@gmail.com',
                'username' => 'doe',
                'phone_no' => '05321230567',
                'date_of_birth' => '1981-09-28',
                'password' => bcrypt('asdf1234'),
                'created_at' => now(),
            ],
            [
                'user_type_id' => UserTypeConstants::DOCTOR,
                'role_id' => RoleConstants::USER,
                'gender_id' => GenderConstants::FEMALE,
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'email' => 'jdoe@gmail.com',
                'username' => 'jdoe',
                'phone_no' => '05321238567',
                'date_of_birth' => '1977-11-28',
                'password' => bcrypt('asdf1234'),
                'created_at' => now(),
            ],
            [
                'user_type_id' => UserTypeConstants::NURSE,
                'role_id' => RoleConstants::USER,
                'gender_id' => GenderConstants::FEMALE,
                'firstname' => 'Jennifer',
                'lastname' => 'Doe',
                'email' => 'jenn@gmail.com',
                'username' => 'jenn',
                'phone_no' => '05321134567',
                'date_of_birth' => '1989-01-28',
                'password' => bcrypt('asdf1234'),
                'created_at' => now(),
            ]
        ];

        User::insert($users);
    }
}
