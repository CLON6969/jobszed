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
        Schema::create('home_table1', function (Blueprint $table) {
            $table->id();
            $table->string('picture'); // To store the background picture
            $table->string('title1');
            $table->text('title1_content');
            $table->string('title1_small_text');
            $table->timestamps(); // created_at and updated_at time
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_table1');
    }
};
