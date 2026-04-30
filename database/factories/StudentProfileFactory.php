<?php

namespace Database\Factories;

use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    protected $model = StudentProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nim' => (string) fake()->unique()->numberBetween(1000000000, 9999999999),
            'faculty' => fake()->randomElement(['FTI', 'FEB', 'FIKOM']),
            'major' => fake()->randomElement(['Informatics', 'Information Systems', 'Business Analytics']),
            'semester' => fake()->numberBetween(1, 8),
            'gpa' => fake()->randomFloat(2, 2.0, 4.0),
        ];
    }
}
