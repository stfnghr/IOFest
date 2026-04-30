<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentValidationController extends Controller
{
    public function index(Request $request): View
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $pending = StudentProfile::query()
            ->where('status', 'pending_validation')
            ->whereHas('user', fn ($q) => $q->where('university_id', $universityId))
            ->with(['user:id,name,email,university_id'])
            ->orderBy('id')
            ->get();

        return view('university.students.validate', [
            'pending' => $pending,
        ]);
    }

    public function verify(Request $request, StudentProfile $student): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);
        abort_unless($student->user()->where('university_id', $universityId)->exists(), 404);

        $student->update(['status' => 'validated']);

        return back()->with('status', 'Student verified.');
    }

    public function reject(Request $request, StudentProfile $student): RedirectResponse
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);
        abort_unless($student->user()->where('university_id', $universityId)->exists(), 404);

        $student->update(['status' => 'rejected']);

        return back()->with('status', 'Student rejected. Ask them to re-upload KTM.');
    }

    public static function ktmUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}
