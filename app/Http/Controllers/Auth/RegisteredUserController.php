<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\StudentProfile;
use App\Models\University;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function createCompany(): View
    {
        return view('auth.company-register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => ['required', 'string', 'max:50'],
            'faculty' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'integer', 'min:1', 'max:20'],
            'ktm' => ['required', 'file', 'image', 'max:5120'],
        ]);

        $domain = Str::lower((string) Str::of($request->string('email')->toString())->afterLast('@'));
        $university = University::query()->where('sso_domain', $domain)->first();
        if (! $university) {
            throw ValidationException::withMessages([
                'email' => 'University domain is not registered. Please use your University email.',
            ]);
        }

        $ktmPath = $request->file('ktm')->store('ktm', 'public');

        $user = User::create([
            'university_id' => $university->id,
            'role' => 'student',
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        StudentProfile::query()->create([
            'user_id' => $user->id,
            'nim' => $request->string('nim')->toString(),
            'faculty' => $request->string('faculty')->toString(),
            'major' => $request->string('major')->toString(),
            'semester' => (int) $request->integer('semester'),
            'gpa' => 0.00,
            'status' => 'pending_validation',
            'ktm_path' => $ktmPath,
        ]);

        UserPreference::query()->create([
            'user_id' => $user->id,
            'interest_categories' => [],
            'work_preference' => 'hybrid',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->to('/onboarding/interests');
    }

    public function storeCompany(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // TODO: enforce business/corporate domains (no free email providers) once rules are finalized.
        $user = User::query()->create([
            'university_id' => null,
            'role' => 'company_hr',
            'name' => $request->string('company_name')->toString().' HR',
            'email' => $request->string('email')->toString(),
            'password' => Hash::make($request->string('password')->toString()),
        ]);

        $company = Company::query()->create([
            'name' => $request->string('company_name')->toString(),
            'email' => $request->string('email')->toString(),
            'nib' => null,
            'npwp' => null,
            'logo_path' => null,
            'banner_path' => null,
            'status' => 'unverified',
        ]);

        $company->users()->attach($user->id, ['role' => 'master']);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->to('/company/pending-verification');
    }
}
