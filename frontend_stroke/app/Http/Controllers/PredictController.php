<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class PredictController extends Controller
{
    public function index()
    {
        return view('predict');
    }

    public function store(Request $request)
    {
        // 1. Ambil data
        $name = $request->patient_name;
        $age = (float) $request->age;
        $hp = (int) $request->hypertension;
        $hd = (int) $request->heart_disease;
        $bmi = (float) $request->bmi;
        $glu = (float) $request->avg_glucose_level;
        $smoke = $request->smoking_status;

        // 2. SIMULASI MODEL PREDIKSI (Logic Algoritma)
        // Kita hitung probabilitas (0 - 100%)
        $prob = 0;

        // Faktor Umur (Makin tua makin rentan)
        if ($age > 60)
            $prob += 20;
        elseif ($age > 45)
            $prob += 10;

        // Faktor Penyakit Kronis (Hipertensi & Jantung adalah pemicu utama)
        if ($hp == 1)
            $prob += 30;
        if ($hd == 1)
            $prob += 30;

        // Faktor Metabolik (Gula & Obesitas)
        if ($glu > 200)
            $prob += 25;
        elseif ($glu > 150)
            $prob += 15;

        if ($bmi > 30)
            $prob += 20;
        elseif ($bmi > 25)
            $prob += 10;

        // Faktor Gaya Hidup
        if ($smoke == 'Aktif')
            $prob += 15;

        // 3. PENENTUAN STATUS (Sesuai Permintaanmu)
        // Di sini kita klasifikasikan hasil akhirnya
        if ($prob >= 80) {
            $status = "TERINDIKASI STROKE";
        } elseif ($prob >= 50) {
            $status = "RISIKO TINGGI";
        } elseif ($prob >= 25) {
            $status = "RISIKO RENDAH";
        } else {
            $status = "TIDAK TERDETEKSI STROKE";
        }

        // 4. Simpan ke Database
        $pasien = Pasien::create([
            'patient_name' => $request->patient_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'hypertension' => $request->hypertension,
            'heart_disease' => $request->heart_disease,
            'avg_glucose_level' => $request->avg_glucose_level,
            'bmi' => $request->bmi,
            'smoking_status' => $request->smoking_status,
            'status_label' => $status,
        ]);

        // REDIRECT ke route result dengan ID pasien
        return redirect()->route('predict.result', ['id' => $pasien->id]);
    }

    // Tambahkan fungsi baru untuk nampilin halaman result
    public function showResult($id)
{
    // Mengambil data pasien berdasarkan ID yang baru diinput
    $pasien = Pasien::findOrFail($id);
    
    // Mengirim data ke view result.blade.php
    return view('result', compact('pasien'));
}
}