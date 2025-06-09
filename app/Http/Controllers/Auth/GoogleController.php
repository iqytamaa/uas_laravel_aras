<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google untuk otentikasi.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback dari Google setelah login berhasil.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Buat atau update data user
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(uniqid()), // password acak, karena login pakai Google
            ]);

            // Login user
            Auth::login($user);

            // Redirect ke /home setelah login berhasil
            return redirect('/home')->with('success', 'Login dengan Google berhasil!');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google_login' => 'Gagal login dengan Google.']);
        }
    }
}
