<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipments = [
            [
                'id' => 1,
                'definition' => 'Dental Chair',
                'quantity' => 5,
            ],
            [
                'id' => 2,
                'definition' => 'X-ray Machine',
                'quantity' => 2,
            ],
            [
                'id' => 3,
                'definition' => 'Autoclave',
                'quantity' => 3,
            ],
            [
                'id' => 4,
                'definition' => 'Disposable Gloves',
                'quantity' => 100,
            ],
            [
                'id' => 5,
                'definition' => 'Single-use Dental Bibs',
                'quantity' => 200,
            ],
        ];

        Equipment::insert($equipments);
    }
}
