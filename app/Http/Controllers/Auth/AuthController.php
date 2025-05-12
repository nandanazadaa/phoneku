<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle login request for regular users
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Cek dulu apakah email ini terdaftar sebagai admin
        $user = User::where('email', $request->email)->first();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Akun ini adalah admin. Silakan login melalui halaman admin.']);
        }

        // Jika bukan admin, lanjutkan proses login user biasa
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Regenerate session ID on login for security

            // Redirect ke URL yang tersimpan di session jika ada
            if ($request->has('redirect')) {
                return redirect()->to($request->redirect);
            } elseif (session()->has('redirect_url')) {
                $redirect = session()->get('redirect_url');
                session()->forget('redirect_url');
                return redirect()->to($redirect);
            }

            return redirect()->intended(route('welcome'));
        }

        return redirect()->back()
            ->withErrors(['auth' => 'Email atau password salah'])
            ->withInput($request->except('password'));
    }

    /**
     * Handle registration request for regular users
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Create user with role "customer" by default
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate(); // Regenerate session ID on login for security

        // Redirect ke URL yang tersimpan di session jika ada
        if ($request->has('redirect')) {
            return redirect()->to($request->redirect);
        } elseif (session()->has('redirect_url')) {
            $redirect = session()->get('redirect_url');
            session()->forget('redirect_url');
            return redirect()->to($redirect);
        }

        return redirect()->route('welcome');
    }

    /**
     * Handle logout request for regular users
     * PERBAIKAN ADA DI FUNGSI INI
     */
    public function logout(Request $request)
    {
        // Hanya logout guard 'web'
        Auth::guard('web')->logout();

        // --- PERBAIKAN ---
        // HAPUS ATAU KOMENTARI BARIS DI BAWAH INI
        // Memanggil invalidate() akan menghancurkan SEMUA data sesi,
        // termasuk status login guard 'admin' jika mereka berbagi session driver.
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // --- AKHIR PERBAIKAN ---

        // Jika Anda masih ingin regenerate CSRF token (biasanya tidak perlu jika tidak invalidate)
        // Anda bisa mengaktifkan baris di bawah ini jika diperlukan, tapi coba tanpa ini dulu.
        // $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    /********************************************
     * Admin Authentication Methods
     ********************************************/

    /**
     * Show admin login form
     */
    public function showAdminLoginForm()
    {
        // If already logged in as admin, you can still show the login page
        // Optionally, display a message indicating they are already logged in
        if (Auth::guard('admin')->check()) {
            return view('auth.admin_login')->with('info', 'You are already logged in as an admin.');
        }
    
        return view('auth.admin_login');
    }

    /**
     * Handle admin login request
     */
    public function adminLogin(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->except('password'));
    }

    // Check if the user exists and has role 'admin'
    $user = User::where('email', $request->email)
                ->where('role', 'admin')
                ->first();

    if (!$user) {
        return redirect()->back()
            ->withErrors(['auth' => 'Invalid credentials'])
            ->withInput($request->except('password'));
    }

    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    // Use the 'admin' guard to attempt login
    if (Auth::guard('admin')->attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    return redirect()->back()
        ->withErrors(['auth' => 'Invalid credentials'])
        ->withInput($request->except('password'));
}

    /**
     * Show admin registration form
     */
    public function showAdminRegistrationForm()
    {
        // Optional: Restrict access to existing admins
        // if (!Auth::guard('admin')->check()) {
        //     return redirect()->route('admin.login')
        //         ->withErrors(['auth' => 'You must be logged in as an admin to access this page']);
        // }

        return view('auth.admin_registrasi'); // Pastikan view ini ada
    }

    /**
     * Handle admin registration request
     */
    public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Create user with role "admin"
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // Redirect ke login admin dengan pesan sukses
        return redirect()->route('admin.login')->with('success', 'Admin berhasil didaftarkan! Silakan login.');
    }

    /**
     * Handle admin logout request
     */
    public function adminLogout(Request $request)
{
    Auth::guard('admin')->logout();

        // Tidak memanggil invalidate() agar tidak mengganggu sesi guard lain (misal 'web')
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}