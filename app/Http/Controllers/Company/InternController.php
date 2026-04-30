<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\InternshipJournal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternController extends Controller
{
    public function index(Request $request): View
    {
        $company = $this->resolveCompany($request);

        $journals = InternshipJournal::query()
            ->whereHas('application', function ($q) use ($company) {
                $q->where('status', 'accepted')
                    ->whereHas('job', fn ($q2) => $q2->where('company_id', $company->id));
            })
            ->with([
                'application:id,user_id,job_id,status',
                'application.user:id,name,university_id',
                'application.user.university:id,name',
                'application.job:id,title',
            ])
            ->orderByDesc('date')
            ->get();

        return view('company.interns.index', [
            'company' => $company,
            'journals' => $journals,
        ]);
    }

    public function approve(Request $request, InternshipJournal $journal): RedirectResponse
    {
        $company = $this->resolveCompany($request);
        abort_unless($journal->application()->whereHas('job', fn ($q) => $q->where('company_id', $company->id))->exists(), 404);

        $journal->update([
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Logbook entry approved.');
    }

    private function resolveCompany(Request $request): Company
    {
        $company = $request->user()->companies()->first();
        abort_unless($company, 403);

        return $company;
    }
}
