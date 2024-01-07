<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treatment_type_id');
            $table->unsignedBigInteger('equipment_id')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->foreign('treatment_type_id')->references('id')->on('treatment_types');
            $table->foreign('equipment_id')->references('id')->on('equipments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
