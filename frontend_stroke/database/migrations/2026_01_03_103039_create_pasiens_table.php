<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pasiens', function (Blueprint $table) {
        $table->id();
        $table->string('patient_name');
        $table->string('gender');
        $table->integer('age');
        $table->boolean('hypertension')->default(0); // 0: Tidak, 1: Ya
        $table->boolean('heart_disease')->default(0); // 0: Tidak, 1: Ya
        $table->float('avg_glucose_level');
        $table->float('bmi');
        $table->string('smoking_status'); // Perokok Aktif, Pasif, Tidak Merokok
        $table->string('status_label'); // STROKE, RISIKO TINGGI, dll
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
