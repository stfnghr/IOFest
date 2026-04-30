<?php

use App\Models\Company;
use App\Models\University;
use App\Models\User;

it('redirects company user to company dashboard from /dashboard', function () {
    $user = User::factory()->create([
        'role' => 'company_hr',
        'university_id' => null,
    ]);
    $company = Company::factory()->create(['status' => 'verified']);
    $company->users()->attach($user->id, ['role' => 'master']);

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect(route('company.dashboard'));
});

it('blocks student from company routes', function () {
    $university = University::factory()->create();
    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
    ]);

    $this->actingAs($student)
        ->get(route('company.dashboard'))
        ->assertForbidden();
});
