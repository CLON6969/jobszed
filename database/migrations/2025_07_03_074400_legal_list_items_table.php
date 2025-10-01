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
Schema::create('legal_list_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('legal_section_id')->constrained()->onDelete('cascade');
    $table->text('item_text');
    $table->integer('order')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('legal_list_items');
    }
};
