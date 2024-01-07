<?php

namespace Database\Seeders;

use App\Constants\Appointment\AppointmentTypeConstants;
use App\Models\Appointment\AppointmentType;
use Illuminate\Database\Seeder;

class AppointmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointmentTypes = [
            [
                'id' => AppointmentTypeConstants::ROUTINE_CHECKUP,
                'title' => 'Routine Checkup',
                'description' => 'A Routine Checkup is a standard appointment for regular dental examinations. It assesses overall oral health, identifies potential issues, and provides preventive care.',
            ],
            [
                'id' => AppointmentTypeConstants::TEETH_CLEANUP,
                'title' => 'Teeth Cleanup',
                'description' => 'Teeth Cleanup involves professional cleaning to remove plaque, tartar, and stains. This promotes optimal oral hygiene and prevents gum diseases.',
            ],
            [
                'id' => AppointmentTypeConstants::TOOTH_EXTRACTION,
                'title' => 'Tooth Extraction',
                'description' => 'Tooth Extraction is the removal of a tooth, typically performed in cases of severe damage, crowding, or other dental issues.',
            ],
            [
                'id' => AppointmentTypeConstants::ROOT_CANAL,
                'title' => 'Root Canal',
                'description' => 'Root Canal is a specialized treatment addressing infections or damage within the tooth\'s pulp. It involves the removal of infected material and sealing the tooth.',
            ],
            [
                'id' => AppointmentTypeConstants::BRACES,
                'title' => 'Braces',
                'description' => 'Braces appointment includes consultation and treatment for orthodontic issues. This involves the application of braces for teeth alignment.',
            ],
            [
                'id' => AppointmentTypeConstants::EMERGENCY_DENTAL_CARE,
                'title' => 'Emergency Dental Care',
                'description' => 'Emergency Dental Care is for urgent appointments, providing immediate attention to dental emergencies such as severe pain, trauma, or sudden dental problems.',
            ],
            [
                'id' => AppointmentTypeConstants::DENTAL_IMPLANTS,
                'title' => 'Dental Implants',
                'description' => 'Dental Implants appointment includes consultation and treatment for the placement of dental implants, offering a solution to replace missing teeth.',
            ],
            [
                'id' => AppointmentTypeConstants::DENTURES,
                'title' => 'Dentures',
                'description' => 'Dentures appointment involves fitting, adjusting, or maintaining dentures. This ensures proper comfort and functionality for patients with missing teeth.',
            ],
            [
                'id' => AppointmentTypeConstants::CROWNS_AND_BRIDGES,
                'title' => 'Crowns and Bridges',
                'description' => 'Crowns and Bridges appointment is a procedure to install crowns or bridges, restoring damaged or missing teeth for enhanced aesthetics and functionality.',
            ],
            [
                'id' => AppointmentTypeConstants::TOOTH_FILLING,
                'title' => 'Tooth Filling',
                'description' => 'Tooth Filling is a treatment for repairing and filling cavities caused by tooth decay, ensuring the restoration of the tooth\'s structure and function.',
            ],
            [
                'id' => AppointmentTypeConstants::TOOTH_WHITENING,
                'title' => 'Tooth Whitening',
                'description' => 'Tooth Whitening is a cosmetic treatment to whiten and brighten teeth, enhancing their appearance for a more vibrant smile.',
            ],
            [
                'id' => AppointmentTypeConstants::VENEERS,
                'title' => 'Veneers',
                'description' => 'Veneers appointment includes consultation and treatment for the application of veneers. This improves the appearance of teeth, addressing cosmetic concerns.',
            ],
        ];

        AppointmentType::insert($appointmentTypes);
    }
}
