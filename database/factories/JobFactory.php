<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(asText: true),
            'category' => fake()->randomElement(['Software', 'Data', 'Product', 'Design', 'Business']),
            'duration' => fake()->randomElement(['3 months', '4 months', '6 months']),
            'work_type' => fake()->randomElement(['remote', 'hybrid', 'on-site']),
            'is_paid' => fake()->boolean(60),
            'status' => 'active',
        ];
    }
}
