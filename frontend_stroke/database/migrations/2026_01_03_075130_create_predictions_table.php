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
    Schema::create('predictions', function (Blueprint $table) {
        $table->id();
        $table->string('patient_name')->default('Pasien Umum');
        $table->integer('age');
        $table->string('gender');
        $table->decimal('bmi', 8, 2);
        $table->decimal('avg_glucose_level', 8, 2);
        $table->string('status_label'); // RISIKO TINGGI / RENDAH
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
