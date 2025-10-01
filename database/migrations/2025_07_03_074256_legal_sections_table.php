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
       Schema::create('legal_sections', function (Blueprint $table) {
    $table->id();
    $table->foreignId('legal_document_id')->constrained()->onDelete('cascade');
    $table->string('heading'); // e.g., 4. Acceptable Use
    $table->text('body')->nullable(); // Description of the section
    $table->integer('order')->default(0); // Order of the section
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
         Schema::dropIfExists('legal_documents');
    }
};
