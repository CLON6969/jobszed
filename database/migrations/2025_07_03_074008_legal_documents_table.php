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
      // 1. legal_documents table
Schema::create('legal_documents', function (Blueprint $table) {
    $table->id();
    $table->string('title'); // Terms of Service / Privacy Policy
    $table->string('slug')->unique(); // terms-of-service / privacy-policy
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};
