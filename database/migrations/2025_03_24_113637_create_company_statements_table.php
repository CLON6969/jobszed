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
        Schema::create('company_statements', function (Blueprint $table) {
            $table->id();
            $table->string('title1');
            $table->text('title1_main_content'); // Note: Fixed typo to match model
            $table->text('title1_sub_content');
            $table->string('background_picture');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_statements');
    }
};