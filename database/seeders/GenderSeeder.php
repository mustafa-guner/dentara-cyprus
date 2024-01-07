<?php

namespace Database\Seeders;

use App\Constants\GenderConstants;
use App\Models\Gender;
use Carbon\Carbon;
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
                'definition' => 'Male',
                'created_at' => Carbon::now()
            ],
            [
                'id' => GenderConstants::FEMALE,
                'definition' => 'Female',
                'created_at' => Carbon::now()
            ],
            [
                'id' => GenderConstants::OTHER,
                'definition' => 'Other',
                'created_at' => Carbon::now()
            ],
            [
                'id' => GenderConstants::NOT_SPECIFIED,
                'definition' => 'Not Specified',
                'created_at' => Carbon::now()
            ]
        ];

        Gender::insert($genders);
    }
}
