<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MajorController extends Controller
{
    public function index(Request $request): View
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $majors = Major::query()
            ->where('university_id', $universityId)
            ->orderBy('name')
            ->get();

        return view('university.majors.index', [
            'majors' => $majors,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Major::query()->firstOrCreate([
            'university_id' => $universityId,
            'name' => $validated['name'],
        ]);

        return back()->with('status', 'Major saved.');
    }

    public function destroy(Request $request, Major $major): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless($major->university_id === $universityId, 404);

        $major->delete();

        return back()->with('status', 'Major deleted.');
    }
}
