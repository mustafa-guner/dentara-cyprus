<?php

namespace Database\Seeders;

use App\Constants\Appointment\AppointmentStatusConstants;
use App\Models\Appointment\AppointmentStatus;
use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointmentStatuses = [
            [
                'id' => AppointmentStatusConstants::IN_PROGRESS,
                'definition' => 'In Progress',
            ],
            [
                'id' => AppointmentStatusConstants::CANCELED,
                'definition' => 'Canceled',
            ],
            [
                'id' => AppointmentStatusConstants::COMPLETED,
                'definition' => 'Completed',
            ],
        ];

        AppointmentStatus::insert($appointmentStatuses);
    }
}
