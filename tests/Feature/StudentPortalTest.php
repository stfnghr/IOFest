<?php

use App\Models\Company;
use App\Models\Job;
use App\Models\Skill;
use App\Models\StudentProfile;
use App\Models\University;
use App\Models\User;
use App\Models\UserPreference;

it('redirects dashboard to student dashboard for student', function () {
    $university = University::factory()->create();
    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
    ]);

    StudentProfile::query()->create([
        'user_id' => $student->id,
        'nim' => '123',
        'faculty' => 'FTI',
        'major' => 'Informatics',
        'semester' => 6,
        'gpa' => 3.5,
        'status' => 'validated',
        'ktm_path' => 'ktm/x.png',
    ]);

    UserPreference::query()->create([
        'user_id' => $student->id,
        'interest_categories' => ['Software'],
        'work_preference' => 'hybrid',
    ]);

    $this->actingAs($student)
        ->get('/dashboard')
        ->assertRedirect(route('student.dashboard'));
});

it('blocks non-student from student portal routes', function () {
    $user = User::factory()->create([
        'role' => 'company_hr',
        'university_id' => null,
    ]);

    $this->actingAs($user)
        ->get(route('student.dashboard'))
        ->assertForbidden();
});

it('scopes jobs to the student university', function () {
    $univA = University::factory()->create();
    $univB = University::factory()->create();

    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $univA->id,
    ]);

    StudentProfile::query()->create([
        'user_id' => $student->id,
        'nim' => '123',
        'faculty' => 'FTI',
        'major' => 'Informatics',
        'semester' => 6,
        'gpa' => 3.5,
        'status' => 'validated',
        'ktm_path' => 'ktm/x.png',
    ]);

    UserPreference::query()->create([
        'user_id' => $student->id,
        'interest_categories' => ['Software'],
        'work_preference' => 'hybrid',
    ]);

    $company = Company::factory()->create(['status' => 'verified']);
    $company->universities()->attach($univA->id, [
        'status' => 'verified',
        'mou_file' => null,
        'mou_expires_at' => now()->addMonths(2)->toDateString(),
    ]);

    $skill = Skill::factory()->create(['name' => 'Laravel', 'category' => 'IT']);

    $jobA = Job::factory()->create([
        'company_id' => $company->id,
        'category' => 'Software',
        'work_type' => 'hybrid',
        'status' => 'active',
    ]);
    $jobA->universities()->attach($univA->id);
    $jobA->skills()->attach($skill->id);

    $jobB = Job::factory()->create([
        'company_id' => $company->id,
        'category' => 'Software',
        'work_type' => 'hybrid',
        'status' => 'active',
    ]);
    $jobB->universities()->attach($univB->id);
    $jobB->skills()->attach($skill->id);

    $this->actingAs($student)
        ->get(route('student.jobs.index'))
        ->assertOk()
        ->assertSee($jobA->title)
        ->assertDontSee($jobB->title);
});
