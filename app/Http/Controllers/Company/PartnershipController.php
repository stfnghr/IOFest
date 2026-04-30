<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnershipController extends Controller
{
    public function index(Request $request): View
    {
        $company = $this->resolveCompany($request);
        $universities = University::query()->orderBy('name')->get();

        $statusMap = $company->universities()
            ->get()
            ->keyBy('id')
            ->map(fn ($university) => [
                'status' => $university->pivot->status,
                'mou_expires_at' => $university->pivot->mou_expires_at,
            ]);

        return view('company.partnerships.index', [
            'company' => $company,
            'universities' => $universities,
            'statusMap' => $statusMap,
        ]);
    }

    public function request(Request $request, University $university): RedirectResponse
    {
        $company = $this->resolveCompany($request);

        $company->universities()->syncWithoutDetaching([
            $university->id => [
                'status' => 'pending',
                'mou_file' => null,
                'mou_expires_at' => now()->addMonths(6)->toDateString(),
            ],
        ]);

        return back()->with('status', 'Permintaan kerja sama berhasil diajukan.');
    }

    private function resolveCompany(Request $request): Company
    {
        $company = $request->user()->companies()->first();
        abort_unless($company, 403);

        return $company;
    }
}
