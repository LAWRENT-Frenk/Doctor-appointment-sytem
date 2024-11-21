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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id'); // BIGINT primary key
            $table->bigInteger('doctor_id')->unsigned(); // Use bigInteger for the foreign key
            $table->bigInteger('patient_id')->unsigned(); // Use bigInteger for the foreign key
            $table->date('date');
            $table->time('time');
            $table->text('reason');
            $table->string('custom_id')->unique()->nullable(); // Custom ID field
            $table->string('status')->default('pending'); // Status field
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
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
