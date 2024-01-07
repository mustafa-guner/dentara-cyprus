<?php

namespace Database\Seeders;

use App\Constants\Payment\PaymentMethodConstants;
use App\Models\Payment\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'id' => PaymentMethodConstants::CASH,
                'definition' => 'Cash',
                'created_at' => Carbon::now()
            ],
            [
                'id' => PaymentMethodConstants::CREDIT_CARD,
                'definition' => 'Credit Card',
                'created_at' => Carbon::now()
            ],
            [
                'id' => PaymentMethodConstants::DEBIT_CARD,
                'definition' => 'Debit Card',
                'created_at' => Carbon::now()
            ],
            [
                'id' => PaymentMethodConstants::CHECK,
                'definition' => 'Check',
                'created_at' => Carbon::now()
            ],
        ];

        PaymentMethod::insert($paymentMethods);
    }
}
