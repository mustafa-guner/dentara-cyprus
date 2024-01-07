<?php

use App\Constants\Appointment\AppointmentStatusConstants;
use App\Constants\Payment\PaymentStatusConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('appointment_date');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('assigned_user_id');
            $table->unsignedBigInteger('appointment_status_id')->default(AppointmentStatusConstants::IN_PROGRESS);
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('payment_status_id')->default(PaymentStatusConstants::PENDING);
            $table->unsignedBigInteger('appointment_type_id');
            $table->unsignedBigInteger('discount_id');
            $table->text('comment')->nullable();
            $table->float('price');
            $table->float('real_price');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('assigned_user_id')->references('id')->on('users');
            $table->foreign('appointment_status_id')->references('id')->on('appointment_statuses');
            $table->foreign('appointment_type_id')->references('id')->on('appointment_types');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
            $table->foreign('discount_id')->references('id')->on('discounts');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
