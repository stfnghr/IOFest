<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UniversityAnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $universityId = $request->user()->university_id;
        abort_unless($universityId, 403);

        $demand = Skill::query()
            ->select(['skills.id', 'skills.name'])
            ->selectRaw('COUNT(job_skills.skill_id) as demand_count')
            ->join('job_skills', 'job_skills.skill_id', '=', 'skills.id')
            ->join('jobs', 'jobs.id', '=', 'job_skills.job_id')
            ->join('job_university', 'job_university.job_id', '=', 'jobs.id')
            ->where('job_university.university_id', $universityId)
            ->where('jobs.status', 'active')
            ->groupBy('skills.id', 'skills.name')
            ->orderByDesc('demand_count')
            ->limit(10)
            ->get();

        $supplyMap = Skill::query()
            ->select(['skills.id'])
            ->selectRaw('COUNT(user_skills.skill_id) as supply_count')
            ->join('user_skills', 'user_skills.skill_id', '=', 'skills.id')
            ->join('users', 'users.id', '=', 'user_skills.user_id')
            ->where('users.role', 'student')
            ->where('users.university_id', $universityId)
            ->groupBy('skills.id')
            ->pluck('supply_count', 'id');

        $skillGap = $demand->map(fn ($row) => [
            'name' => $row->name,
            'demand' => (int) $row->demand_count,
            'supply' => (int) ($supplyMap[$row->id] ?? 0),
        ]);

        $totalStudents = User::query()
            ->where('role', 'student')
            ->where('university_id', $universityId)
            ->count();

        $acceptedStudents = Application::query()
            ->where('status', 'accepted')
            ->whereHas('user', fn ($q) => $q->where('university_id', $universityId))
            ->distinct('user_id')
            ->count('user_id');

        $internshipRate = $totalStudents > 0 ? round(($acceptedStudents / $totalStudents) * 100, 1) : 0.0;

        return view('university.analytics.index', [
            'skillGap' => $skillGap,
            'internshipRate' => $internshipRate,
            'totalStudents' => $totalStudents,
            'acceptedStudents' => $acceptedStudents,
        ]);
    }
}
