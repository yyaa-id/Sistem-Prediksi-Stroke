<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class StrokeController extends Controller
{
    public function index()
    {
        return view('predict');
    }

    public function predict(Request $request)
    {
        // 1. Mapping Teks ke Angka (Sesuai Dataset AI)
        $gender = ($request->gender == 'Laki-laki') ? 0.5 : 0.0;
        $married = ($request->ever_married == 'Ya') ? 1.0 : 0.0;

        $smoking_map = [
            'Tidak Pernah' => 0.0,
            'Pasif' => 0.33,
            'Aktif' => 0.66,
            'Berhenti' => 1.0
        ];
        $smoking = $smoking_map[$request->smoking_status] ?? 0.0;

        // 2. Siapkan data untuk dikirim ke API Flask
        $data = [
            'gender' => $gender,
            'age' => (float) $request->age / 100,
            'hypertension' => (float) $request->hypertension,
            'heart_disease' => (float) $request->heart_disease,
            'ever_married' => $married,
            'work_type' => 0.5,
            'Residence_type' => 0.5,
            'avg_glucose_level' => (float) $request->avg_glucose_level / 300,
            'bmi' => (float) $request->bmi / 50,
            'smoking_status' => $smoking,
        ];

        try {
            // 3. Kirim ke Flask (Gess, jangan lupa Flask-nya di-RUN dulu ya!)
            $response = Http::timeout(5)->post('http://127.0.0.1:5000/predict', $data);

            if ($response->successful()) {
                $result = $response->json();
                
                // 4. Logika Penentuan Status Medis
                $status = 'RISIKO RENDAH';
                
                if ($result['result'] == 0) {
                    if ((float)$request->age < 30 && (float)$request->bmi < 25 && $request->hypertension == 0) {
                        $status = 'TIDAK ADA RISIKO';
                    } else {
                        $status = 'RISIKO RENDAH';
                    }
                } elseif ($result['result'] == 1) {
                    $status = 'RISIKO TINGGI';
                }

                // 5. Tampilkan hasil ke halaman Surat Diagnosa (Result)
                return view('result', [
                    'prediction' => $result['result'],
                    'status_label' => $status,
                    'pasien' => $request->all()
                ]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi ke server AI Gagal. Cek terminal Flask kamu!');
        }

        return back()->with('error', 'Gagal memproses data dari AI.');
    }
}