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
        Schema::create('job_page', function (Blueprint $table) {
            $table->id();
            $table->string('background_picture'); // Background picture
            $table->string('title1'); // Title1
            $table->text('title1_content'); // Title1 content
            $table->string('button1_name'); // Button1 name
            $table->string('button1_url'); // Button1 URL
            $table->string('button2_name')->nullable(); // Button2 name (nullable)
            $table->string('button2_url')->nullable(); // Button2 URL (nullable)
            $table->string('title2'); // Title2

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
