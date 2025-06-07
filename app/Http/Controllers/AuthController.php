<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    /**
     * Proses login dengan validasi input, reCAPTCHA, dan pembatasan percobaan.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Silakan centang captcha terlebih dahulu.',
        ]);

        $captchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $captchaResult = $captchaResponse->json();

        if (!($captchaResult['success'] ?? false)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Verifikasi captcha gagal. Silakan coba lagi.'
            ])->withInput();
        }

        $attemptsLeft    = $request->session()->get('login_attempts_left', 5);
        $delayStartTime  = $request->session()->get('delay_start_time');

        if ($attemptsLeft === 0) {
            $now = time();
            if ($delayStartTime && ($now - $delayStartTime) < 10) {
                $waitTime = 10 - ($now - $delayStartTime);

                Log::warning('Gagal login oleh: ' . $request->email . ' dari IP: ' . $request->ip());

                return back()->withErrors([
                    'email' => "Percobaan login habis. Silakan tunggu $waitTime detik."
                ])->withInput();
            } else {
                $request->session()->put('login_attempts_left', 5);
                $request->session()->forget('delay_start_time');
                $attemptsLeft = 5;
            }
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->forget('login_attempts_left');
            $request->session()->forget('delay_start_time');
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        $attemptsLeft--;
        $request->session()->put('login_attempts_left', $attemptsLeft);

        if ($attemptsLeft === 0) {
            $request->session()->put('delay_start_time', time());
            return back()->withErrors([
                'email' => "Percobaan login habis. Silakan tunggu 10 detik."
            ])->withInput();
        }

        return back()->withErrors([
            'email' => "Email atau password salah. Sisa percobaan: $attemptsLeft."
        ])->withInput();
    }

    /**
     * Logout dan bersihkan session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Tampilkan form register.
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    /**
     * Proses pendaftaran user baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }
}
