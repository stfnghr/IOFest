<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Services\MatchScoreService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyDashboardController extends Controller
{
    public function index(Request $request, MatchScoreService $matchScoreService): View
    {
        $company = $this->resolveCompany($request);
        $selectedUniversityId = $request->integer('university_id') ?: null;

        $verifiedUniversities = $company->universities()
            ->wherePivot('status', 'verified')
            ->wherePivot('mou_expires_at', '>=', now()->toDateString())
            ->orderBy('name')
            ->get(['universities.id', 'universities.name']);

        $applicationsQuery = Application::query()
            ->whereHas('job', fn ($q) => $q->where('company_id', $company->id))
            ->with([
                'user:id,university_id',
                'user.skills:id',
                'user.userPreference:id,user_id,interest_categories,work_preference',
                'job:id,company_id,category,work_type',
                'job.skills:id',
            ]);

        if ($selectedUniversityId) {
            $applicationsQuery->whereHas('user', fn ($q) => $q->where('university_id', $selectedUniversityId));
        }

        $applications = $applicationsQuery->get();

        $totalApplicants = $applications->count();
        $slaWarning = $applications
            ->filter(fn (Application $application) => in_array($application->status, ['applied', 'under_review'], true))
            ->filter(fn (Application $application) => $application->applied_at && $application->applied_at->diffInDays(now()) > 5)
            ->count();
        $hiredInterns = $applications->where('status', 'accepted')->count();

        $avgMatch = (int) round($applications->map(function (Application $application) use ($matchScoreService) {
            return $matchScoreService->calculate($application->user, $application->job);
        })->avg() ?? 0);

        return view('company.dashboard', [
            'company' => $company,
            'verifiedUniversities' => $verifiedUniversities,
            'selectedUniversityId' => $selectedUniversityId,
            'totalApplicants' => $totalApplicants,
            'avgMatch' => $avgMatch,
            'slaWarning' => $slaWarning,
            'hiredInterns' => $hiredInterns,
        ]);
    }

    private function resolveCompany(Request $request): Company
    {
        $company = $request->user()->companies()->first();
        abort_unless($company, 403);

        return $company;
    }
}
