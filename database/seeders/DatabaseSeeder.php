<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Company;
use App\Models\Job;
use App\Models\Skill;
use App\Models\StudentProfile;
use App\Models\University;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $univA = University::query()->create([
            'name' => 'Universitas Ciputra',
            'sso_domain' => 'student.ciputra.ac.id',
            'logo_path' => null,
        ]);

        $univB = University::query()->create([
            'name' => 'Universitas Tarumanagara',
            'sso_domain' => 'student.untar.ac.id',
            'logo_path' => null,
        ]);

        $skills = collect([
            ['name' => 'Python', 'category' => 'IT'],
            ['name' => 'Laravel', 'category' => 'IT'],
            ['name' => 'Flutter', 'category' => 'IT'],
            ['name' => 'Data Science', 'category' => 'Data'],
            ['name' => 'SQL', 'category' => 'Data'],
            ['name' => 'Pandas', 'category' => 'Data'],
            ['name' => 'Matplotlib', 'category' => 'Data'],
            ['name' => 'Tableau', 'category' => 'Business'],
            ['name' => 'C#', 'category' => 'IT'],
            ['name' => 'Computer Vision', 'category' => 'Data'],
        ])->map(fn (array $data) => Skill::query()->create($data));

        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'university_id' => null,
            'name' => 'Super Admin',
            'email' => 'superadmin@uchub.test',
            'password' => Hash::make('password'),
        ]);

        $univAdminA = User::factory()->create([
            'role' => 'univ_admin',
            'university_id' => $univA->id,
            'name' => 'UC Admin',
            'email' => 'admin@ciputra.ac.id',
            'password' => Hash::make('password'),
        ]);

        $univAdminB = User::factory()->create([
            'role' => 'univ_admin',
            'university_id' => $univB->id,
            'name' => 'UNTAR Admin',
            'email' => 'admin@untar.ac.id',
            'password' => Hash::make('password'),
        ]);

        $companyHr1 = User::factory()->create([
            'role' => 'company_hr',
            'university_id' => null,
            'name' => 'HR DB Klik',
            'email' => 'hr@dbklik.com',
            'password' => Hash::make('password'),
        ]);

        $companyHr2 = User::factory()->create([
            'role' => 'company_hr',
            'university_id' => null,
            'name' => 'HR DWP Group',
            'email' => 'hr@dwpgroup.com',
            'password' => Hash::make('password'),
        ]);

        $students = collect()
            ->merge(
                User::factory()
                    ->count(3)
                    ->create(['role' => 'student', 'university_id' => $univA->id])
            )
            ->merge(
                User::factory()
                    ->count(2)
                    ->create(['role' => 'student', 'university_id' => $univB->id])
            );

        $students->each(function (User $student) use ($skills): void {
            StudentProfile::query()->create([
                'user_id' => $student->id,
                'nim' => (string) fake()->unique()->numberBetween(1000000000, 9999999999),
                'faculty' => fake()->randomElement(['FTI', 'FEB', 'FIKOM']),
                'major' => fake()->randomElement(['Informatics', 'Information Systems', 'Business Analytics']),
                'semester' => fake()->numberBetween(2, 8),
                'gpa' => fake()->randomFloat(2, 2.0, 4.0),
            ]);

            UserPreference::query()->create([
                'user_id' => $student->id,
                'interest_categories' => fake()->randomElements(
                    ['Frontend', 'Backend', 'Data', 'UI/UX', 'Product', 'HR', 'Marketing'],
                    fake()->numberBetween(3, 5)
                ),
                'work_preference' => fake()->randomElement(['remote', 'hybrid', 'on-site']),
            ]);

            $studentSkills = $skills->random(fake()->numberBetween(3, 6));
            foreach ($studentSkills as $skill) {
                $student->skills()->attach($skill->id, [
                    'proficiency_level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
                ]);
            }
        });

        $company1 = Company::query()->create([
            'name' => 'DB Klik',
            'email' => 'contact@dbklik.com',
            'nib' => 'NIB-DBKLIK-001',
            'npwp' => 'NPWP-DBKLIK-001',
            'logo_path' => null,
            'banner_path' => null,
            'status' => 'verified',
        ]);

        $company2 = Company::query()->create([
            'name' => 'DWP Group',
            'email' => 'contact@dwpgroup.com',
            'nib' => 'NIB-DWP-001',
            'npwp' => 'NPWP-DWP-001',
            'logo_path' => null,
            'banner_path' => null,
            'status' => 'verified',
        ]);

        $company1->users()->attach($companyHr1->id, ['role' => 'master']);
        $company2->users()->attach($companyHr2->id, ['role' => 'master']);

        $company1->universities()->attach($univA->id, [
            'status' => 'verified',
            'mou_file' => null,
            'mou_expires_at' => now()->addMonths(6)->toDateString(),
        ]);

        $company1->universities()->attach($univB->id, [
            'status' => 'verified',
            'mou_file' => null,
            'mou_expires_at' => now()->addMonths(6)->toDateString(),
        ]);

        $company2->universities()->attach($univA->id, [
            'status' => 'verified',
            'mou_file' => null,
            'mou_expires_at' => now()->addMonths(6)->toDateString(),
        ]);

        $job1 = Job::query()->create([
            'company_id' => $company1->id,
            'title' => 'Backend Intern (Laravel)',
            'description' => 'Build API features, improve database queries, and write tests.',
            'category' => 'Software',
            'duration' => '6 months',
            'status' => 'active',
        ]);

        $job2 = Job::query()->create([
            'company_id' => $company1->id,
            'title' => 'Data Analyst Intern',
            'description' => 'Help analyze business data and build dashboards for decision making.',
            'category' => 'Data',
            'duration' => '4 months',
            'status' => 'active',
        ]);

        $job3 = Job::query()->create([
            'company_id' => $company2->id,
            'title' => 'Mobile Intern (Flutter)',
            'description' => 'Build cross-platform mobile features and maintain app quality.',
            'category' => 'Software',
            'duration' => '3 months',
            'status' => 'active',
        ]);

        $job1->universities()->sync([$univA->id]);
        $job2->universities()->sync([$univA->id, $univB->id]);
        $job3->universities()->sync([$univB->id]);

        $skillByName = $skills->keyBy('name');
        $job1->skills()->sync([
            $skillByName['Laravel']->id,
            $skillByName['SQL']->id,
        ]);
        $job2->skills()->sync([
            $skillByName['SQL']->id,
            $skillByName['Pandas']->id,
            $skillByName['Tableau']->id,
        ]);
        $job3->skills()->sync([
            $skillByName['Flutter']->id,
            $skillByName['Python']->id,
        ]);

        $job1->customQuestions()->createMany([
            ['question' => 'Lampirkan link GitHub Anda.', 'is_required' => true],
            ['question' => 'Ceritakan project Laravel terbaik yang pernah Anda buat.', 'is_required' => false],
        ]);

        $job2->customQuestions()->createMany([
            ['question' => 'Lampirkan link portfolio dashboard/BI (jika ada).', 'is_required' => false],
        ]);

        $job3->customQuestions()->createMany([
            ['question' => 'Pernah membuat aplikasi Flutter yang dipublish? Jelaskan.', 'is_required' => false],
        ]);

        // Optional: add a few applications for realism.
        $students->take(3)->each(function (User $student) use ($job1, $job2): void {
            Application::query()->create([
                'user_id' => $student->id,
                'job_id' => fake()->randomElement([$job1->id, $job2->id]),
                'status' => 'applied',
                'applied_at' => now()->subDays(fake()->numberBetween(0, 5)),
                'cover_letter' => fake()->boolean(60) ? fake()->paragraph() : null,
            ]);
        });
    }
}
