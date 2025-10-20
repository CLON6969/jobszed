<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
Schema::create('messages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('reply_to_id')->nullable()->constrained('messages')->nullOnDelete();

    $table->text('content')->nullable();
    $table->string('media_path')->nullable();
    $table->string('media_type')->nullable(); // image, video, file, etc.

    $table->string('channel')->default('in-app');
    $table->string('status')->default('sent'); // sent, read
    $table->boolean('is_deleted')->default(false);
    $table->json('metadata')->nullable();

    $table->timestamps();
});

    }

    public function down(): void {
        Schema::dropIfExists('messages');
    }
};
