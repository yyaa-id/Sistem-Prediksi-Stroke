<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{    
    public function showLogin()
    {
        // Generate kode acak
        $captcha = substr(str_shuffle("23456789ABCDEFGHJKLMNPQRSTUVWXYZ"), 0, 5);
        session(['captcha_code' => $captcha]);
        return view('login', compact('captcha'));
    }

    public function login(Request $request)
    {
        // 1. Verifikasi Captcha (Case Insensitive)
        if (strtoupper($request->captcha_input) !== session('captcha_code')) {
            return back()->with('error', 'Kode Verifikasi Salah!');
        }

        // 2. Kunci Email Spesifik (Hanya email ini yang boleh login)
        $targetEmail = 'admin@rs-pusat.com';
        if ($request->email !== $targetEmail) {
            return back()->with('error', 'Akses Ditolak: Email tidak terdaftar dalam otoritas pusat.');
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/predict');
        }

        return back()->with('error', 'Kredensial salah atau akun tidak aktif.');
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $user = auth()->user();

    // 1. Cek apakah password lama benar
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Password lama kamu salah gess!');
    }

    // 2. Update ke password baru
    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return back()->with('success', 'Password berhasil diperbarui!');
}

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}