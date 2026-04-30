<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Services\MatchScoreService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request, MatchScoreService $matchScoreService): View
    {
        $student = $request->user()->loadMissing([
            'skills:id',
            'userPreference:id,user_id,interest_categories,work_preference',
        ]);

        $universityId = $student->university_id;

        $query = Job::query()
            ->where('status', 'active')
            ->whereHas('universities', fn ($q) => $q->where('universities.id', $universityId))
            ->whereHas('company.universities', function ($q) use ($universityId) {
                $q->where('universities.id', $universityId)
                    ->where('company_university.status', 'verified')
                    ->whereDate('company_university.mou_expires_at', '>=', now()->toDateString());
            })
            ->with([
                'company:id,name,status,logo_path',
                'skills:id,name',
                'universities:id',
            ]);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category')->toString());
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->string('work_type')->toString());
        }

        if ($request->boolean('paid')) {
            $query->where('is_paid', true);
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder
                    ->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%");
            });
        }

        $jobs = $query->latest('id')->paginate(12)->withQueryString();

        $jobsWithScores = $jobs->getCollection()->map(function (Job $job) use ($student, $matchScoreService) {
            $job->setAttribute('match_score', $matchScoreService->calculate($student, $job));

            return $job;
        });

        $jobs->setCollection($jobsWithScores);

        $categories = Job::query()
            ->where('status', 'active')
            ->whereHas('universities', fn ($q) => $q->where('universities.id', $universityId))
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('student.jobs.index', [
            'jobs' => $jobs,
            'categories' => $categories,
        ]);
    }

    public function show(Request $request, Job $job, MatchScoreService $matchScoreService): View
    {
        $student = $request->user()->loadMissing([
            'skills:id,name',
            'userPreference:id,user_id,interest_categories,work_preference',
        ]);

        abort_unless($job->universities()->where('universities.id', $student->university_id)->exists(), 404);

        abort_unless(
            $job->company()
                ->whereHas('universities', function ($q) use ($student) {
                    $q->where('universities.id', $student->university_id)
                        ->where('company_university.status', 'verified')
                        ->whereDate('company_university.mou_expires_at', '>=', now()->toDateString());
                })
                ->exists(),
            404
        );

        $job->loadMissing([
            'company:id,name,status,logo_path',
            'skills:id,name',
        ]);

        $requiredSkillIds = $job->skills->pluck('id');
        $studentSkillIds = $student->skills->pluck('id');

        $ownedSkills = $job->skills->filter(fn ($skill) => $studentSkillIds->contains($skill->id))->values();
        $gapSkills = $job->skills->filter(fn ($skill) => ! $studentSkillIds->contains($skill->id))->values();

        $score = $matchScoreService->calculate($student, $job);

        $isCompanyVerified = $job->company->status === 'verified';

        $completeness = 0;
        $student->loadMissing('studentProfile:id,user_id,nim,faculty,major,semester,ktm_path');
        $completeness += ($student->studentProfile?->nim && $student->studentProfile?->faculty && $student->studentProfile?->major) ? 35 : 0;
        $completeness += ($student->studentProfile?->semester) ? 10 : 0;
        $completeness += ($student->studentProfile?->ktm_path) ? 15 : 0;
        $completeness += (count($student->userPreference?->interest_categories ?? []) >= 3) ? 20 : 0;
        $completeness += ($student->skills->count() >= 3) ? 20 : 0;

        return view('student.jobs.show', [
            'job' => $job,
            'score' => $score,
            'ownedSkills' => $ownedSkills,
            'gapSkills' => $gapSkills,
            'isCompanyVerified' => $isCompanyVerified,
            'profileCompleteness' => $completeness,
        ]);
    }
}
