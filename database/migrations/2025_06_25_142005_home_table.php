<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('home', function (Blueprint $table) {
            $table->id();

            // Images
            $table->string('background_picture')->nullable();
            $table->string('picture1')->nullable();
            $table->string('background_picture2')->nullable();

            // Titles & Content
            $table->string('title1');
            $table->text('title1_content')->nullable();
            $table->text('title1_sub_content')->nullable();
            $table->string('title2');
            $table->text('title2_content')->nullable();
            $table->string('title3')->nullable();
            $table->text('title3_content')->nullable();
            $table->text('title3_sub_content')->nullable();
            $table->string('title4')->nullable();
            $table->text('title4_content')->nullable();
            $table->text('title4_sub_content')->nullable();

            // Buttons
            $table->string('button1_name')->nullable();
            $table->string('button1_url')->nullable();
            $table->string('button2_name')->nullable();
            $table->string('button2_url')->nullable();
            $table->string('button3_name')->nullable();
            $table->string('button3_url')->nullable();
            $table->string('button4_name')->nullable();
            $table->string('button4_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home');
    }
};
