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
        Schema::create('about_table', function (Blueprint $table) {
            $table->id(); // Creates auto-incrementing bigint unsigned primary key
            $table->string('picture');
            $table->string('title1');
            $table->text('title1_content');
            $table->string('title1_small_text');
            $table->timestamps(); // Creates created_at and updated_at timestamp fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_table');
    }
};