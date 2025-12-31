<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show Login Form
    public function showLogin()
    {
        return view('auth.masuk');
    }

    // Process Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/admin-panel/dashboard');
            }

            return redirect()->intended('/mahasiswa/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Show Register Form
    public function showRegister()
    {
        return view('auth.daftar');
    }

    // Process Register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nim' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_telp' => 'nullable|string',
            'alamat' => 'nullable|string',
            // 'kategori' => 'nullable|in:photographer,videographer,prerelease',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim' => $validated['nim'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
            'no_telp' => $validated['no_telp'],
            'alamat' => $validated['alamat'],
            // 'kategori' => $validated['kategori'],
        ]);

        Auth::login($user);

        return redirect('/mahasiswa/dashboard')->with('success', 'Registrasi berhasil!');
    }

    // Show Forgot Password Form
    public function showForgotPassword()
    {
        return view('auth.lupa-password');
    }

    // Process Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password telah dikirim ke email Anda!')
            : back()->withErrors(['email' => 'Email tidak ditemukan.']);
    }

    // Show Reset Password Form
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // Process Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset!')
            : back()->withErrors(['email' => 'Reset password gagal.']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Show Change Password Form
    public function showChangePassword()
    {
        return view('auth.ubah-password');
    }

    // Process Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
