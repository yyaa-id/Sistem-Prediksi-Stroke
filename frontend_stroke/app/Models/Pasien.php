<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    // Ini supaya Laravel izinkan data disimpan lewat Controller
    protected $fillable = [
        'patient_name', 
        'gender', 
        'age', 
        'hypertension', 
        'heart_disease', 
        'avg_glucose_level', 
        'bmi', 
        'smoking_status', 
        'status_label'
    ];
}