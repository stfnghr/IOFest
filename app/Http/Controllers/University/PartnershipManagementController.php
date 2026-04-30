<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnershipManagementController extends Controller
{
    public function index(Request $request): View
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $incoming = Company::query()
            ->whereHas('universities', function ($q) use ($universityId) {
                $q->where('universities.id', $universityId)->where('company_university.status', 'pending');
            })
            ->orderBy('companies.name')
            ->get(['companies.id', 'companies.name', 'companies.email', 'companies.status']);

        $active = Company::query()
            ->whereHas('universities', function ($q) use ($universityId) {
                $q->where('universities.id', $universityId)->where('company_university.status', 'verified');
            })
            ->orderBy('companies.name')
            ->get(['companies.id', 'companies.name', 'companies.email', 'companies.status']);

        $active->load(['universities' => function ($q) use ($universityId) {
            $q->where('universities.id', $universityId);
        }]);

        return view('university.partnerships.index', [
            'incoming' => $incoming,
            'active' => $active,
        ]);
    }

    public function approve(Request $request, Company $company): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $company->universities()->syncWithoutDetaching([
            $universityId => [
                'status' => 'verified',
                'mou_file' => null,
                'mou_expires_at' => now()->addYear()->toDateString(),
            ],
        ]);

        return back()->with('status', 'Partnership approved.');
    }

    public function reject(Request $request, Company $company): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $company->universities()->syncWithoutDetaching([
            $universityId => [
                'status' => 'rejected',
                'mou_file' => null,
                'mou_expires_at' => now()->addYear()->toDateString(),
            ],
        ]);

        return back()->with('status', 'Partnership rejected.');
    }
}
