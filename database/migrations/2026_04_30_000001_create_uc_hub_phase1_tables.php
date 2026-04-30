<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nim');
            $table->string('faculty');
            $table->string('major');
            $table->integer('semester');
            $table->decimal('gpa', 3, 2);
            $table->timestamps();
        });

        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->json('interest_categories');
            $table->enum('work_preference', ['remote', 'hybrid', 'on-site']);
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->timestamps();
        });

        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced']);
            $table->timestamps();

            $table->unique(['user_id', 'skill_id']);
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('nib')->nullable();
            $table->string('npwp')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->enum('status', ['unverified', 'pending', 'verified', 'suspended'])->default('unverified');
            $table->timestamps();
        });

        Schema::create('company_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['master', 'hr']);
            $table->timestamps();

            $table->unique(['company_id', 'user_id']);
        });

        Schema::create('company_university', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('mou_file')->nullable();
            $table->date('mou_expires_at');
            $table->timestamps();

            $table->unique(['company_id', 'university_id']);
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('duration');
            $table->enum('status', ['active', 'hidden', 'closed'])->default('active');
            $table->timestamps();
        });

        Schema::create('job_university', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['job_id', 'university_id']);
        });

        Schema::create('job_skills', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['job_id', 'skill_id']);
        });

        Schema::create('job_custom_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->text('question');
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });

        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->enum('status', ['applied', 'under_review', 'interview', 'accepted', 'rejected'])->default('applied');
            $table->timestamp('applied_at');
            $table->text('cover_letter')->nullable();
            $table->timestamps();
        });

        Schema::create('application_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('status');
            $table->timestamp('changed_at');
            $table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('internship_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->date('date');
            $table->text('content');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_journals');
        Schema::dropIfExists('application_status_logs');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('job_custom_questions');
        Schema::dropIfExists('job_skills');
        Schema::dropIfExists('job_university');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('company_university');
        Schema::dropIfExists('company_users');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('user_skills');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('user_preferences');
        Schema::dropIfExists('students');
    }
};
