<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenderSeeder::class,
            UserTypeSeeder::class,
            RoleSeeder::class,
            PaymentStatusSeeder::class,
            PaymentMethodSeeder::class,
            AppointmentTypeSeeder::class,
            AppointmentStatusSeeder::class,
            EquipmentSeeder::class,
            TreatmentTypeSeeder::class,
            DiscountSeeder::class,
            UserSeeder::class,
        ]);
    }
}
