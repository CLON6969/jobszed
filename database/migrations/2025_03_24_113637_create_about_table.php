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
        Schema::create('about', function (Blueprint $table) {
            $table->id(); // Creates auto-incrementing bigint unsigned primary key
            $table->string('background_picture');
            $table->string('title1');
            $table->text('title1_content');
            $table->string('title2');
            $table->text('title2_content');
            $table->string('button1_name');
            $table->string('button1_url');
            $table->string('background_picture2');
            $table->string('title3');
            $table->text('title3_content');
            $table->string('title4');
            $table->text('title4_content');
            $table->string('title5');
            $table->string('button2_name');
            $table->string('button2_url');
            $table->string('title6');
            $table->timestamps(); // Creates created_at and updated_at timestamp fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about');
    }
};