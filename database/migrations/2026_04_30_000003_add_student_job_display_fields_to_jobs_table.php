<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->enum('work_type', ['remote', 'hybrid', 'on-site'])->default('hybrid')->after('duration');
            $table->boolean('is_paid')->default(false)->after('work_type');
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['work_type', 'is_paid']);
        });
    }
};
