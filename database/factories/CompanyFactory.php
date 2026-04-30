<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->unique()->companyEmail(),
            'nib' => (string) fake()->numberBetween(100000000, 999999999),
            'npwp' => (string) fake()->numberBetween(100000000, 999999999),
            'logo_path' => null,
            'banner_path' => null,
            'status' => 'verified',
        ];
    }
}
