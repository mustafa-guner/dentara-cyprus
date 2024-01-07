<?php

namespace Database\Seeders;

use App\Constants\Payment\PaymentStatusConstants;
use App\Models\Payment\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentStatuses = [
            [
                'id' => PaymentStatusConstants::PENDING,
                'definition' => 'Pending'
            ],
            [
                'id' => PaymentStatusConstants::PAID,
                'definition' => 'Paid'
            ],
            [
                'id' => PaymentStatusConstants::REFUNDED,
                'definition' => 'Refunded'
            ],
        ];

        PaymentStatus::insert($paymentStatuses);
    }
}
