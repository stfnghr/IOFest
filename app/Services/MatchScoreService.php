<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;

class MatchScoreService
{
    public function calculate(User $student, Job $job): int
    {
        $requiredSkillIds = $job->skills->pluck('id')->unique();
        $totalRequired = $requiredSkillIds->count();

        if ($totalRequired === 0) {
            return 100;
        }

        $studentSkillIds = $student->skills->pluck('id')->unique();
        $overlap = $requiredSkillIds->intersect($studentSkillIds)->count();

        $baseScore = (int) round(($overlap / $totalRequired) * 100);

        $bonus = 0;

        $userPreference = $student->relationLoaded('userPreference')
            ? $student->getRelation('userPreference')
            : $student->userPreference()->first();

        $interestCategories = collect($userPreference?->interest_categories ?? []);
        $workPreference = $userPreference?->work_preference;

        if ($interestCategories->contains($job->category)) {
            $bonus += 5;
        }

        if ($workPreference && $job->work_type && $workPreference === $job->work_type) {
            $bonus += 5;
        }

        return min($baseScore + $bonus, 100);
    }
}
