<?php




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nav1', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // Menu label
            $table->string('name_url');    // Link URL
            $table->unsignedBigInteger('parent_id')->nullable(); // Dropdown parent
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('nav1')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nav1');
    }
};
