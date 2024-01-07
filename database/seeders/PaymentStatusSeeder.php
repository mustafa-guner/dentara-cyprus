<?php

namespace Database\Seeders;

use App\Constants\Payment\PaymentStatusConstants;
use App\Models\Payment\PaymentStatus;
use Carbon\Carbon;
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
                'definition' => 'Pending',
                'created_at' => Carbon::now()
            ],
            [
                'id' => PaymentStatusConstants::PAID,
                'definition' => 'Paid',
                'created_at' => Carbon::now()
            ],
            [
                'id' => PaymentStatusConstants::REFUNDED,
                'definition' => 'Refunded',
                'created_at' => Carbon::now()
            ],
        ];

        PaymentStatus::insert($paymentStatuses);
    }
}
