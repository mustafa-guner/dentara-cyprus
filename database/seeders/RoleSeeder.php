<?php

namespace Database\Seeders;

use App\Constants\User\RoleConstants;
use App\Models\User\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => RoleConstants::ADMIN,
                'definition' => 'Admin',
                'created_at' => Carbon::now()
            ],
            [
                'id' => RoleConstants::USER,
                'definition' => 'User',
                'created_at' => Carbon::now()
            ]
        ];

        Role::insert($roles);
    }
}
