<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\Skill;
use App\Models\StudentProfile;
use App\Models\UserPreference;
use App\Services\MatchScoreService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function dashboard(Request $request, MatchScoreService $matchScoreService): View
    {
        $student = $request->user()->loadMissing([
            'skills:id',
            'userPreference:id,user_id,interest_categories,work_preference',
            'studentProfile:id,user_id,status',
            'university:id,name',
        ]);

        $universityId = $student->university_id;

        $activeApplicationsCount = Application::query()
            ->where('user_id', $student->id)
            ->whereIn('status', ['applied', 'under_review', 'interview'])
            ->count();

        $interviewInvitesCount = Application::query()
            ->where('user_id', $student->id)
            ->where('status', 'interview')
            ->count();

        $jobs = Job::query()
            ->select(['jobs.*'])
            ->where('status', 'active')
            ->whereHas('universities', fn ($q) => $q->where('universities.id', $universityId))
            ->whereHas('company.universities', function ($q) use ($universityId) {
                $q->where('universities.id', $universityId)
                    ->where('company_university.status', 'verified')
                    ->whereDate('company_university.mou_expires_at', '>=', now()->toDateString());
            })
            ->with([
                'company:id,name,status,logo_path',
                'skills:id',
            ])
            ->limit(50)
            ->get();

        $jobScores = $jobs->map(function (Job $job) use ($student, $matchScoreService) {
            $score = $matchScoreService->calculate($student, $job);

            return [
                'job' => $job,
                'score' => $score,
            ];
        })->sortByDesc('score')->values();

        $recommended = $jobScores->take(5);
        $averageMatch = (int) round($jobScores->avg('score') ?? 0);

        $skillRadar = $student->skills
            ->take(6)
            ->values()
            ->map(fn ($skill) => [
                'label' => $skill->name,
                'value' => match ($skill->pivot?->proficiency_level) {
                    'advanced' => 90,
                    'intermediate' => 65,
                    default => 40,
                },
            ]);

        return view('student.dashboard', [
            'student' => $student,
            'activeApplicationsCount' => $activeApplicationsCount,
            'interviewInvitesCount' => $interviewInvitesCount,
            'averageMatch' => $averageMatch,
            'recommended' => $recommended,
            'skillRadar' => $skillRadar,
        ]);
    }

    public function editProfile(Request $request): View
    {
        $student = $request->user()->loadMissing([
            'studentProfile',
            'userPreference',
            'skills:id,name,category',
        ]);

        $allSkills = Skill::query()
            ->select(['id', 'name', 'category'])
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('student.profile.edit', [
            'student' => $student,
            'allSkills' => $allSkills,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $student = $request->user();

        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:50'],
            'faculty' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'integer', 'min:1', 'max:20'],
            'work_preference' => ['required', 'in:remote,hybrid,on-site'],
            'interest_categories' => ['array'],
            'interest_categories.*' => ['string', 'max:50'],
            'skill_ids' => ['array'],
            'skill_ids.*' => ['integer', 'exists:skills,id'],
        ]);

        StudentProfile::query()->updateOrCreate(
            ['user_id' => $student->id],
            [
                'nim' => $validated['nim'],
                'faculty' => $validated['faculty'],
                'major' => $validated['major'],
                'semester' => $validated['semester'],
            ]
        );

        UserPreference::query()->updateOrCreate(
            ['user_id' => $student->id],
            [
                'interest_categories' => $validated['interest_categories'] ?? [],
                'work_preference' => $validated['work_preference'],
            ]
        );

        $student->skills()->sync(collect($validated['skill_ids'] ?? [])->mapWithKeys(fn ($id) => [
            $id => ['proficiency_level' => 'beginner'],
        ])->all());

        return back()->with('status', 'Profile updated.');
    }
}
