<?php

namespace Database\Seeders;

use App\Constants\Payment\PaymentMethodConstants;
use App\Models\Payment\PaymentMethod;
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
                'definition' => 'Cash'
            ],
            [
                'id' => PaymentMethodConstants::CREDIT_CARD,
                'definition' => 'Credit Card'
            ],
            [
                'id' => PaymentMethodConstants::DEBIT_CARD,
                'definition' => 'Debit Card'
            ],
            [
                'id' => PaymentMethodConstants::CHECK,
                'definition' => 'Check'
            ],
        ];

        PaymentMethod::insert($paymentMethods);
    }
}
