<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('footer_items', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('footer_title_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Add index for better performance
            $table->index('footer_title_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('footer_items');
    }
};