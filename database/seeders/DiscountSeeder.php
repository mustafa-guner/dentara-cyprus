<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discounts = [
            [
                'definition' => '5-10 Aged Patients',
                'percentage' => 50
            ],
            [
                'definition' => '70-80 Aged Patients',
                'percentage' => 50
            ]
        ];

        Discount::insert($discounts);
    }
}
