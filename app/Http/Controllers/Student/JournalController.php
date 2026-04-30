<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\InternshipJournal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(Request $request): View
    {
        $student = $request->user();

        $acceptedApplications = Application::query()
            ->where('user_id', $student->id)
            ->where('status', 'accepted')
            ->with(['job:id,title,company_id', 'job.company:id,name'])
            ->get();

        $applicationIds = $acceptedApplications->pluck('id');

        $journals = InternshipJournal::query()
            ->whereIn('application_id', $applicationIds)
            ->orderByDesc('date')
            ->get()
            ->groupBy('application_id');

        return view('student.journals.index', [
            'acceptedApplications' => $acceptedApplications,
            'journals' => $journals,
        ]);
    }

    public function store(Request $request, Application $application): RedirectResponse
    {
        $student = $request->user();
        abort_unless($application->user_id === $student->id && $application->status === 'accepted', 404);

        $request->validate([
            'date' => ['required', 'date'],
            'content' => ['required', 'string', 'max:10000'],
        ]);

        InternshipJournal::query()->updateOrCreate(
            [
                'application_id' => $application->id,
                'date' => $request->date('date')->toDateString(),
            ],
            [
                'content' => $request->string('content')->toString(),
            ]
        );

        return back()->with('status', 'Journal entry saved.');
    }

    public function print(Request $request, Application $application): View
    {
        $student = $request->user();
        abort_unless($application->user_id === $student->id && $application->status === 'accepted', 404);

        $application->loadMissing(['job:id,title,company_id', 'job.company:id,name', 'internshipJournals']);

        return view('student.journals.print', [
            'application' => $application,
        ]);
    }
}
