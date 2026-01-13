<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Konstruktor untuk memastikan hanya Admin Utama yang bisa akses.
     * Ini proteksi lapis kedua selain di Sidebar & Route.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin_utama') {
                return redirect('/dashboard')->with('error', 'Akses Ditolak! Anda bukan Admin Utama.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar admin/user
     */
    public function index()
    {
        // Mengambil semua user, bisa dipaginate jika datanya banyak
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Menyimpan user/admin baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin_utama,staf',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    /**
     * Menghapus user
     */
    public function destroy(User $user)
    {
        // Mencegah admin utama menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}