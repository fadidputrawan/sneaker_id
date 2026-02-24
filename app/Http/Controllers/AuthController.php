<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ================== HALAMAN LOGIN USER ==================
    public function showLogin()
    {
        return view('auth.login');
    }

    // ================== HALAMAN REGISTER ==================
    public function showRegister()
    {
        return view('auth.register');
    }

    // ================== PROSES LOGIN USER (ROLE USER ONLY) ==================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 🔥 BATASI HANYA ROLE USER
        $credentials['role'] = 'user';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('login_error', 'Email / Password salah atau bukan akun user');
    }

    // ================== PROSES REGISTER ==================
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user' // 🔥 DEFAULT ROLE USER
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }

    // ================== LOGIN ADMIN ==================
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->with('login_error', 'Login Admin gagal');
    }

    // ================== LOGIN PETUGAS ==================
    public function loginPetugas(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials['role'] = 'petugas';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('petugas.dashboard');
        }

        return back()->with('login_error', 'Login Petugas gagal');
    }

    // ================== LOGOUT ==================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}