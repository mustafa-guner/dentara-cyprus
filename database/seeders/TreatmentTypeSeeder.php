<?php

namespace Database\Seeders;

use App\Constants\Treatment\TreatmentTypeConstants;
use App\Models\Treatment\TreatmentType;
use Illuminate\Database\Seeder;

class TreatmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatmentTypes = [
            [
                'id' => TreatmentTypeConstants::RESTORATIVE_DENTISTRY,
                'title' => 'Restorative Dentistry',
                'description' => 'Restorative dentistry is the study, diagnosis, and integrated management of diseases of the teeth and their supporting structures. It involves the rehabilitation of the dentition to functional and aesthetic requirements of the individual.',
                'price' => 1000,
            ],
            [
                'id' => TreatmentTypeConstants::ORTHODONTIC_TREATMENT,
                'title' => 'Orthodontic Treatment',
                'description' => 'Orthodontic treatment involves the correction of malocclusion and misaligned teeth using braces, aligners, or other orthodontic devices.',
                'price' => 1000,
            ],
            [
                'id' => TreatmentTypeConstants::ENDODONTIC_TREATMENT,
                'title' => 'Endodontic Treatment',
                'description' => 'Endodontic treatment, commonly known as root canal therapy, deals with the treatment of the dental pulp and tissues surrounding the roots of the tooth.',
                'price' => 1000,
            ],
            [
                'id' => TreatmentTypeConstants::PROPHYLACTIC_TREATMENT,
                'title' => 'Prophylactic Treatment',
                'description' => 'Prophylactic treatment focuses on preventive measures to maintain oral health, including professional cleanings, fluoride treatments, and oral hygiene education.',
                'price' => 1000,
            ],
            [
                'id' => TreatmentTypeConstants::SURGICAL_PROCEDURES,
                'title' => 'Surgical Procedures',
                'description' => 'Surgical procedures in dentistry include various interventions such as tooth extractions, dental implants, and other surgical treatments to address oral health issues.',
                'price' => 1000,
            ],
            [
                'id' => TreatmentTypeConstants::COSMETIC_DENTISTRY,
                'title' => 'Cosmetic Dentistry',
                'description' => 'Cosmetic dentistry aims to improve the appearance of teeth, gums, and bite. It includes procedures like teeth whitening, veneers, and cosmetic bonding.',
                'price' => 1000,
            ],
            [
                'id' => TreatmentTypeConstants::PERIODONTAL_TREATMENT,
                'title' => 'Periodontal Treatment',
                'description' => 'Periodontal treatment focuses on the prevention and treatment of diseases affecting the supporting structures of the teeth, including gums and bones.',
                'price' => 1000,
            ],
        ];

        TreatmentType::insert($treatmentTypes);
    }
}
