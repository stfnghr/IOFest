<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Services\MatchScoreService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function index(Request $request, MatchScoreService $matchScoreService): View
    {
        $company = $this->resolveCompany($request);

        $query = Application::query()
            ->whereHas('job', fn ($q) => $q->where('company_id', $company->id))
            ->with([
                'user:id,name,email,university_id',
                'user.university:id,name',
                'user.skills:id,name',
                'job:id,company_id,title,category,work_type',
                'job.skills:id,name',
            ])
            ->latest('applied_at');

        if ($request->filled('university_id')) {
            $query->whereHas('user', fn ($q) => $q->where('university_id', $request->integer('university_id')));
        }

        if ($request->filled('job_id')) {
            $query->where('job_id', $request->integer('job_id'));
        }

        $applications = $query->get()->map(function (Application $application) use ($matchScoreService) {
            $application->setAttribute('match_score', $matchScoreService->calculate($application->user, $application->job));

            return $application;
        });

        if ($request->filled('min_match_rate')) {
            $min = (int) $request->integer('min_match_rate');
            $applications = $applications->filter(fn (Application $a) => $a->match_score >= $min)->values();
        }

        $jobs = $company->jobs()->orderBy('title')->get(['id', 'title']);
        $universities = $company->universities()
            ->wherePivot('status', 'verified')
            ->orderBy('name')
            ->get(['universities.id', 'universities.name']);

        return view('company.candidates.index', [
            'company' => $company,
            'applications' => $applications,
            'jobs' => $jobs,
            'universities' => $universities,
        ]);
    }

    public function show(Request $request, Application $application, MatchScoreService $matchScoreService): View
    {
        $company = $this->resolveCompany($request);
        abort_unless($application->job()->where('company_id', $company->id)->exists(), 404);

        $application->load([
            'user:id,name,email,university_id',
            'user.university:id,name',
            'user.studentProfile:id,user_id,nim,faculty,major,semester,gpa',
            'user.skills:id,name',
            'job:id,company_id,title,category,work_type',
            'job.skills:id,name',
        ]);

        $matchScore = $matchScoreService->calculate($application->user, $application->job);
        $userSkillIds = $application->user->skills->pluck('id');
        $owned = $application->job->skills->filter(fn ($skill) => $userSkillIds->contains($skill->id))->values();
        $gaps = $application->job->skills->filter(fn ($skill) => ! $userSkillIds->contains($skill->id))->values();

        return view('company.candidates.show', [
            'application' => $application,
            'matchScore' => $matchScore,
            'ownedSkills' => $owned,
            'gapSkills' => $gaps,
        ]);
    }

    public function decide(Request $request, Application $application): RedirectResponse
    {
        $company = $this->resolveCompany($request);
        abort_unless($application->job()->where('company_id', $company->id)->exists(), 404);

        $validated = $request->validate([
            'decision' => ['required', 'in:reject,interview,hire'],
        ]);

        $newStatus = match ($validated['decision']) {
            'reject' => 'rejected',
            'interview' => 'interview',
            'hire' => 'accepted',
        };

        $application->update(['status' => $newStatus]);
        $application->statusLogs()->create([
            'status' => $newStatus,
            'changed_at' => now(),
            'changed_by' => $request->user()->id,
        ]);

        return back()->with('status', 'Status kandidat berhasil diperbarui.');
    }

    private function resolveCompany(Request $request): Company
    {
        $company = $request->user()->companies()->first();
        abort_unless($company, 403);

        return $company;
    }
}
