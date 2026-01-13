<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PredictController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\DB;
use App\Models\Pasien;

// 1. PINTU UTAMA
Route::get('/', function () {
    return redirect('/login');
});

// 2. AUTHENTICATION
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', function (Request $request) {
    // Validasi sederhana
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    
    // 1. Ambil kode captcha yang sedang tampil di layar (dari session)
    $captcha_session = session('captcha_code'); 

    // 2. Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'captcha_input' => 'required'
    ]);

    // 3. CEK CAPTCHA (Ini kuncinya!)
    // Kita samakan inputan kamu dengan yang ada di session
    if (strtoupper($request->captcha_input) !== strtoupper($captcha_session)) {
        return back()->with('error', 'Kode Verifikasi Salah! Silakan coba lagi.')->withInput();
    }

    // 4. Kalau Captcha benar, baru cek Email & Password
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    // 5. Kalau password salah
    return back()->with('error', 'Email atau Password salah!')->withInput();

    // Proses Cek Login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// 3. FITUR UTAMA (APLIKASI)
Route::middleware(['auth'])->group(function () {

    // --- A. Menu yang bisa diakses SEMUA staf (Skrining, Pasien, Statistik dll) ---

    // 1. Halaman Home
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // 2. Halaman Skrining
    Route::get('/predict', [PredictController::class, 'index'])->name('predict.index');
    Route::post('/predict', [PredictController::class, 'store'])->name('predict.store');
    Route::get('/predict/result/{id}', [PredictController::class, 'showResult'])->name('predict.result');

    // 3. Halaman Data Pasien
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::put('/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');

    // 4. Halaman Statistik
    Route::get('/statistik', function (Request $request) {
        // Ambil input tanggal, kalau kosong pakai default
        $start = $request->query('start_date', date('Y-01-01'));
        $end = $request->query('end_date', date('Y-12-31'));

        // Tambahkan jam agar filter 'end_date' mencakup seluruh hari tersebut (23:59:59)
        $startDate = $start . " 00:00:00";
        $endDate = $end . " 23:59:59";

        // Hitung kategori (DIFILTER TANGGAL)
        $pieData = [
            Pasien::whereBetween('created_at', [$startDate, $endDate])->where('status_label', 'LIKE', '%TERINDIKASI%')->count(),
            Pasien::whereBetween('created_at', [$startDate, $endDate])->where('status_label', 'LIKE', '%TINGGI%')->count(),
            Pasien::whereBetween('created_at', [$startDate, $endDate])->where('status_label', 'LIKE', '%RENDAH%')->count(),
            Pasien::whereBetween('created_at', [$startDate, $endDate])
                ->where(function($q) {
                    $q->where('status_label', 'LIKE', '%TIDAK TERDETEKSI%')
                        ->orWhere('status_label', 'Normal');
                })->count(),
        ];

        // Ambil data tren bulanan (DIFILTER TANGGAL)
        $trenData = Pasien::select(
                DB::raw('COUNT(id) as total'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as bulan"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as urutan")
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('bulan', 'urutan')
            ->orderBy('urutan', 'asc')
            ->get();

        return view('statistik', compact('pieData', 'trenData'));
        })->name('statistik.index');

    // --- B. KHUSUS ADMIN UTAMA SAJA (Pintu Terkunci) ---
    
    Route::middleware(['checkRole:admin_utama'])->group(function () {
        // Menggunakan resource agar otomatis mencakup index, store, destroy, dll.
        Route::resource('users', UserController::class);
    });

    // Profile
    Route::get('/profile', function () {
        return view('profile'); });

    // Settings
    Route::get('/settings', function () {
        return view('settings'); });
    Route::post('/settings', [AuthController::class, 'updatePassword']);

    Route::post('/settings/notifications', function (Request $request) {
    $user = Auth::user();
    
    // Update berdasarkan input switch
    $user->update([
        'notif_email_risiko_tinggi' => $request->has('notif_email'),
        'notif_suara_alarm' => $request->has('notif_alarm'),
        'notif_laporan_mingguan' => $request->has('notif_laporan'),
    ]);

    return back()->with('success', 'Preferensi notifikasi berhasil diperbarui!');
})->name('settings.notifications');
});