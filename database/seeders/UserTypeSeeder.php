<?php

namespace Database\Seeders;

use App\Constants\User\UserTypeConstants;
use App\Models\User\UserType;
use Carbon\Carbon;
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
                'created_at' => Carbon::now()
            ],
            [
                'id' => UserTypeConstants::DOCTOR,
                'definition' => 'Doctor',
                'created_at' => Carbon::now()
            ],
            [
                'id' => UserTypeConstants::NURSE,
                'definition' => 'Nurse',
                'created_at' => Carbon::now()
            ]
        ];

        UserType::insert($userTypes);
    }
}
