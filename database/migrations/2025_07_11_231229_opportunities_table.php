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
        //
        Schema::create('opportunities', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('summary');
        $table->string('image'); // relative path like 'uploads/pics/219.jpg'
        $table->string('overlay_intro');
        $table->text('overlay_details');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('opportunities');
    }
};
