<?php

namespace Database\Seeders;

use App\Constants\GenderConstants;
use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = [
            [
                'id' => GenderConstants::MALE,
                'definition' => 'Male'
            ],
            [
                'id' => GenderConstants::FEMALE,
                'definition' => 'Female'
            ],
            [
                'id' => GenderConstants::OTHER,
                'definition' => 'Other'
            ],
            [
                'id' => GenderConstants::NOT_SPECIFIED,
                'definition' => 'Not Specified'
            ]
        ];

        Gender::insert($genders);
    }
}
