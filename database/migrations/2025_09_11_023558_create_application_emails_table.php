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
    Schema::create('application_emails', function (Blueprint $table) {
        $table->id();
        $table->foreignId('job_application_id')->constrained()->onDelete('cascade');
        $table->enum('status', ['accepted','interview','shortlisted','rejected']);
        $table->text('email_content')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_emails');
    }
};
