<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UniversityDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $totalStudents = User::query()
            ->where('role', 'student')
            ->where('university_id', $universityId)
            ->count();

        $verifiedPartners = Company::query()
            ->whereHas('universities', function ($q) use ($universityId) {
                $q->where('universities.id', $universityId)->where('company_university.status', 'verified');
            })
            ->count();

        $totalJobs = Job::query()
            ->where('status', 'active')
            ->whereHas('universities', fn ($q) => $q->where('universities.id', $universityId))
            ->count();

        $recentPartnershipRequests = Company::query()
            ->whereHas('universities', function ($q) use ($universityId) {
                $q->where('universities.id', $universityId)->where('company_university.status', 'pending');
            })
            ->latest('companies.id')
            ->limit(5)
            ->get(['companies.id', 'companies.name', 'companies.email']);

        $recentStudentRegistrations = User::query()
            ->where('role', 'student')
            ->where('university_id', $universityId)
            ->latest('id')
            ->limit(5)
            ->get(['id', 'name', 'email', 'created_at']);

        return view('university.dashboard', [
            'totalStudents' => $totalStudents,
            'verifiedPartners' => $verifiedPartners,
            'totalJobs' => $totalJobs,
            'recentPartnershipRequests' => $recentPartnershipRequests,
            'recentStudentRegistrations' => $recentStudentRegistrations,
        ]);
    }
}
