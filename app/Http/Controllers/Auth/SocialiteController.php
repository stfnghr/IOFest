<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        // Demo implementation: use Google as the SSO provider.
        // In production, this should point to the University's SSO provider (Google/Microsoft).
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $email = (string) $googleUser->email;
        $domain = Str::lower((string) Str::of($email)->afterLast('@'));

        $university = University::query()->where('sso_domain', $domain)->first();
        if (! $university) {
            abort(403, 'University domain is not registered.');
        }

        $user = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'university_id' => $university->id,
                'role' => 'student',
                'name' => $googleUser->name ?? 'Student',
                'password' => Hash::make(Str::random(64)),
            ]
        );

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
