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
        Schema::create('logo', function (Blueprint $table) {
            $table->id();
            $table->string('picture'); // To store the logo picture
             $table->string('picture2'); // To store the logo picture2
             $table->string('title');
             $table->string('home_url');
              $table->string('background_picture'); // To store the background picture of both the login and register pages
            $table->timestamps(); // created_at and updated_at time
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logo');
    }
};
