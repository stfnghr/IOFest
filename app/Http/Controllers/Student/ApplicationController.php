<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $student = $request->user();

        $applications = Application::query()
            ->where('user_id', $student->id)
            ->with([
                'job:id,company_id,title,category,work_type,is_paid',
                'job.company:id,name,logo_path',
            ])
            ->latest('applied_at')
            ->get();

        $columns = collect([
            'applied' => 'Applied',
            'under_review' => 'Under Review',
            'interview' => 'Interview',
            'accepted' => 'Decision',
            'rejected' => 'Decision',
        ]);

        $grouped = $applications->groupBy('status');

        $now = now();
        $applications->each(function (Application $application) use ($now) {
            $application->setAttribute('sla_days', $application->applied_at ? $application->applied_at->diffInDays($now) : 0);
            $application->setAttribute('sla_breached', $application->applied_at ? $application->applied_at->diffInDays($now) >= 7 : false);
        });

        return view('student.applications.index', [
            'columns' => $columns,
            'grouped' => $grouped,
            'applications' => $applications,
        ]);
    }

    public function store(Request $request, Job $job): RedirectResponse
    {
        $student = $request->user()->loadMissing([
            'studentProfile:id,user_id,status,ktm_path',
            'userPreference:id,user_id,interest_categories,work_preference',
            'skills:id',
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

        $request->validate([
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ]);

        $completeness = 0;
        $completeness += ($student->studentProfile?->nim && $student->studentProfile?->faculty && $student->studentProfile?->major) ? 35 : 0;
        $completeness += ($student->studentProfile?->semester) ? 10 : 0;
        $completeness += ($student->studentProfile?->ktm_path) ? 15 : 0;
        $completeness += (count($student->userPreference?->interest_categories ?? []) >= 3) ? 20 : 0;
        $completeness += ($student->skills->count() >= 3) ? 20 : 0;

        if ($completeness < 80) {
            return back()->with('status', 'Profilmu belum siap. Lengkapi profil hingga minimal 80% sebelum apply.');
        }

        $alreadyApplied = Application::query()
            ->where('user_id', $student->id)
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('status', 'You have already applied to this job.');
        }

        $application = Application::query()->create([
            'user_id' => $student->id,
            'job_id' => $job->id,
            'status' => 'applied',
            'applied_at' => Carbon::now(),
            'cover_letter' => $request->string('cover_letter')->toString() ?: null,
        ]);

        return redirect()->route('student.applications.index')
            ->with('status', 'Application submitted.');
    }

    public function requestIntervention(Request $request, Application $application): RedirectResponse
    {
        $student = $request->user();
        abort_unless($application->user_id === $student->id, 404);

        // Stub: In Phase 2 this would dispatch a notification to University Admin.
        return back()->with('status', 'Campus Intervention requested. An admin will follow up with the company.');
    }
}
