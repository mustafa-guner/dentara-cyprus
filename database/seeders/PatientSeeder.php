<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'firstname' => 'Johanna',
                'lastname' => 'Carol',
                'phone_no' => '5338783131',
                'address' => 'Kaimakli/Nicosia',
                'gender_id' => 2,
                'date_of_birth' => '1999-01-01',
                'created_by' => 1
            ],
            [
                'firstname' => 'Kyle',
                'lastname' => 'Tanzia',
                'phone_no' => '5338782131',
                'address' => 'Kaimakli/Nicosia',
                'gender_id' => 1,
                'date_of_birth' => '1999-01-01',
                'created_by' => 1
            ],
            [
                'firstname' => 'Marry',
                'lastname' => 'Canastly',
                'phone_no' => '5338783231',
                'address' => 'Kyrenia',
                'gender_id' => 1,
                'date_of_birth' => '1999-01-01',
                'created_by' => 1
            ]
        ];

        Patient::insert($patients);
    }
}
