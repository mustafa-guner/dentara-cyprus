<?php

namespace Database\Seeders;

use App\Constants\User\UserTypeConstants;
use App\Models\User\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            [
                'id' => UserTypeConstants::SYSTEM_USER,
                'definition' => 'System User',
            ],
            [
                'id' => UserTypeConstants::DOCTOR,
                'definition' => 'Doctor',
            ],
            [
                'id' => UserTypeConstants::NURSE,
                'definition' => 'Nurse',
            ]
        ];

        UserType::insert($userTypes);
    }
}
