<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyJobController extends Controller
{
    public function index(Request $request): View
    {
        $company = $this->resolveCompany($request);
        $jobs = Job::query()
            ->where('company_id', $company->id)
            ->withCount('applications')
            ->latest('id')
            ->get();

        return view('company.jobs.index', [
            'company' => $company,
            'jobs' => $jobs,
        ]);
    }

    public function create(Request $request): View
    {
        $company = $this->resolveCompany($request);

        $skills = Skill::query()->orderBy('category')->orderBy('name')->get();
        $targetUniversities = $company->universities()
            ->wherePivot('status', 'verified')
            ->wherePivot('mou_expires_at', '>=', now()->toDateString())
            ->orderBy('name')
            ->get(['universities.id', 'universities.name']);

        return view('company.jobs.create', [
            'company' => $company,
            'skills' => $skills,
            'targetUniversities' => $targetUniversities,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $company = $this->resolveCompany($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255'],
            'work_type' => ['required', 'in:remote,hybrid,on-site'],
            'is_paid' => ['nullable', 'boolean'],
            'status' => ['required', 'in:active,hidden,closed'],
            'skill_ids' => ['array'],
            'skill_ids.*' => ['integer', 'exists:skills,id'],
            'target_university_ids' => ['required', 'array', 'min:1'],
            'target_university_ids.*' => ['integer', 'exists:universities,id'],
            'custom_questions' => ['array'],
            'custom_questions.*.question' => ['required', 'string', 'max:1000'],
            'custom_questions.*.is_required' => ['nullable', 'boolean'],
        ]);

        $verifiedUniversityIds = $company->universities()
            ->wherePivot('status', 'verified')
            ->wherePivot('mou_expires_at', '>=', now()->toDateString())
            ->pluck('universities.id');

        $targetIds = collect($validated['target_university_ids'] ?? []);
        abort_unless($targetIds->every(fn ($id) => $verifiedUniversityIds->contains($id)), 422);

        $job = Job::query()->create([
            'company_id' => $company->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'duration' => $validated['duration'],
            'work_type' => $validated['work_type'],
            'is_paid' => (bool) ($validated['is_paid'] ?? false),
            'status' => $validated['status'],
        ]);

        $job->skills()->sync($validated['skill_ids'] ?? []);
        $job->universities()->sync($validated['target_university_ids']);

        foreach ($validated['custom_questions'] ?? [] as $question) {
            $job->customQuestions()->create([
                'question' => $question['question'],
                'is_required' => (bool) ($question['is_required'] ?? false),
            ]);
        }

        return redirect()->route('company.jobs.index')->with('status', 'Lowongan berhasil dibuat.');
    }

    private function resolveCompany(Request $request): Company
    {
        $company = $request->user()->companies()->first();
        abort_unless($company, 403);

        return $company;
    }
}
