<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('guest_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_token')->unique();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('interactions')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('guest_sessions');
    }
};
