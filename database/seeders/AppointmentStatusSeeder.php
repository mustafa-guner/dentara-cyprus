<?php

namespace Database\Seeders;

use App\Constants\Appointment\AppointmentStatusConstants;
use App\Models\Appointment\AppointmentStatus;
use Carbon\Carbon;
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
                'created_at' => Carbon::now()
            ],
            [
                'id' => AppointmentStatusConstants::CANCELED,
                'definition' => 'Canceled',
                'created_at' => Carbon::now()
            ],
            [
                'id' => AppointmentStatusConstants::COMPLETED,
                'definition' => 'Completed',
                'created_at' => Carbon::now()
            ],
        ];

        AppointmentStatus::insert($appointmentStatuses);
    }
}
