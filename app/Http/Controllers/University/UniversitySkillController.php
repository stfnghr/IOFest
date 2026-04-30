<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UniversitySkillController extends Controller
{
    public function index(Request $request): View
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $skills = Skill::query()
            ->where('university_id', $universityId)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('university.skills.index', [
            'skills' => $skills,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        Skill::query()->create([
            'university_id' => $universityId,
            'name' => $validated['name'],
            'category' => $validated['category'],
        ]);

        return back()->with('status', 'Skill saved.');
    }

    public function destroy(Request $request, Skill $skill): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless((int) $skill->university_id === (int) $universityId, 404);

        $skill->delete();

        return back()->with('status', 'Skill deleted.');
    }
}
