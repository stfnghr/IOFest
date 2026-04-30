<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Company\CandidateController;
use App\Http\Controllers\Company\CompanyDashboardController;
use App\Http\Controllers\Company\CompanyJobController;
use App\Http\Controllers\Company\InternController;
use App\Http\Controllers\Company\PartnershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ApplicationController;
use App\Http\Controllers\Student\JobController;
use App\Http\Controllers\Student\JournalController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\University\MajorController;
use App\Http\Controllers\University\PartnershipManagementController;
use App\Http\Controllers\University\StudentValidationController;
use App\Http\Controllers\University\UniversityAnalyticsController;
use App\Http\Controllers\University\UniversityDashboardController;
use App\Http\Controllers\University\UniversitySkillController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    $role = auth()->user()?->role;

    return match ($role) {
        'company_hr' => redirect()->route('company.dashboard'),
        'student' => redirect()->route('dashboard'),
        'univ_admin' => redirect()->route('university.dashboard'),
        'super_admin' => redirect()->route('dashboard'),
        default => redirect()->route('dashboard'),
    };
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'company_hr' => redirect()->route('company.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'univ_admin' => redirect()->route('university.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'company'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');

    Route::get('/partnerships', [PartnershipController::class, 'index'])->name('partnerships.index');
    Route::post('/partnerships/{university}/request', [PartnershipController::class, 'request'])->name('partnerships.request');

    Route::get('/jobs', [CompanyJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [CompanyJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [CompanyJobController::class, 'store'])->name('jobs.store');

    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::get('/candidates/{application}', [CandidateController::class, 'show'])->name('candidates.show');
    Route::post('/candidates/{application}/decision', [CandidateController::class, 'decide'])->name('candidates.decide');

    Route::get('/interns', [InternController::class, 'index'])->name('interns.index');
    Route::post('/interns/journals/{journal}/approve', [InternController::class, 'approve'])->name('interns.approve');
});

Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');

    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/applications/{application}/request-intervention', [ApplicationController::class, 'requestIntervention'])
        ->name('applications.request-intervention');

    Route::get('/profile', [StudentController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');

    Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::post('/journals/{application}', [JournalController::class, 'store'])->name('journals.store');
    Route::get('/journals/{application}/print', [JournalController::class, 'print'])->name('journals.print');
});

Route::middleware(['auth', 'university'])->prefix('university')->name('university.')->group(function () {
    Route::get('/dashboard', [UniversityDashboardController::class, 'index'])->name('dashboard');

    Route::get('/partnerships', [PartnershipManagementController::class, 'index'])->name('partnerships.index');
    Route::post('/partnerships/{company}/approve', [PartnershipManagementController::class, 'approve'])->name('partnerships.approve');
    Route::post('/partnerships/{company}/reject', [PartnershipManagementController::class, 'reject'])->name('partnerships.reject');

    Route::get('/students/validate', [StudentValidationController::class, 'index'])->name('students.validate');
    Route::post('/students/{student}/verify', [StudentValidationController::class, 'verify'])->name('students.verify');
    Route::post('/students/{student}/reject', [StudentValidationController::class, 'reject'])->name('students.reject');

    Route::get('/analytics', [UniversityAnalyticsController::class, 'index'])->name('analytics.index');

    Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
    Route::post('/majors', [MajorController::class, 'store'])->name('majors.store');
    Route::delete('/majors/{major}', [MajorController::class, 'destroy'])->name('majors.destroy');

    Route::get('/skills', [UniversitySkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [UniversitySkillController::class, 'store'])->name('skills.store');
    Route::delete('/skills/{skill}', [UniversitySkillController::class, 'destroy'])->name('skills.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::view('/onboarding/interests', 'onboarding.interests')->name('onboarding.interests');
    Route::view('/company/pending-verification', 'auth.company-pending-verification')->name('company.pending');
});
