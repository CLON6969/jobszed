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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug'); // removed unique()
            $table->text('description');
            $table->text('responsibilities')->nullable();
            $table->text('benefits')->nullable();
            $table->enum('employment_type', ['full time', 'part time', 'contract', 'internship'])->default('full_time');
            $table->enum('work_setup', ['on site', 'remote', 'hybrid'])->default('on site');
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->string('department')->nullable();
            $table->string('level')->nullable();
            $table->string('salary_range')->nullable();
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
