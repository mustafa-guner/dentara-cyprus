<?php

namespace Database\Seeders;

use App\Constants\User\RoleConstants;
use App\Models\User\Role;
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
            ],
            [
                'id' => RoleConstants::USER,
                'definition' => 'User',
            ]
        ];

        Role::insert($roles);
    }
}
