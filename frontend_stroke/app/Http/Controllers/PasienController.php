<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function index(Request $request)
{
    
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');

    $riwayat = Pasien::when($search, function($query) use ($search) {
        // 1. Bersihkan tanda '#' kalau ada
        $cleanSearch = str_replace('#', '', $search);
        
        // 2. Hilangkan angka 0 di depan (misal: 0001 jadi 1)
        $cleanId = ltrim($cleanSearch, '0');

        $query->where(function($q) use ($search, $cleanId) {
            $q->where('patient_name', 'LIKE', "%{$search}%");
            
            // 3. Cari berdasarkan ID asli kalau inputan tadi berupa angka
            if (is_numeric($cleanId)) {
                $q->orWhere('id', $cleanId);
            }
        });
    })
    ->latest()
    ->paginate($perPage);

    return view('pasien', compact('riwayat'));
}

    // Fungsi untuk nampilin halaman input (pasien/index.blade.php)
public function create()
{
    return view('pasien.index'); 
}

    public function store(Request $request)
{
    // 1. Validasi Data (Biar nggak ada data kosong yang masuk)
    $request->validate([
        'patient_name' => 'required|string|max:255',
        'age' => 'required|integer',
        'gender' => 'required',
        'hypertension' => 'required',
        'heart_disease' => 'required',
    ]);

    // 2. Simulasi Logika AI (Untuk Poin 8 Tugas MLOps)
    // Di sini kita tentukan status_label berdasarkan input medis sederhana
    $status_label = 'RISIKO RENDAH'; // Default
    
    if ($request->hypertension == 1 && $request->heart_disease == 1) {
        $status_label = 'TERINDIKASI STROKE';
    } elseif ($request->hypertension == 1 || $request->age > 60) {
        $status_label = 'RISIKO TINGGI';
    }

    // 3. Simpan ke Database
    Pasien::create([
        'patient_name' => $request->patient_name,
        'age' => $request->age,
        'gender' => $request->gender,
        'hypertension' => $request->hypertension,
        'heart_disease' => $request->heart_disease,
        'avg_glucose_level' => $request->avg_glucose_level,
        'bmi' => $request->bmi,
        'status_label' => $status_label, // Hasil "AI" disimpan di sini
    ]);

    // 4. Redirect ke halaman arsip (file pasien.blade.php kamu)
    return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dianalisis oleh AI!');
}

    public function destroy($id)
    {
        Pasien::findOrFail($id)->delete();
        return back()->with('success', 'Data rekam medis berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());
        return back()->with('success', 'Data pasien berhasil diperbarui.');
    }
}