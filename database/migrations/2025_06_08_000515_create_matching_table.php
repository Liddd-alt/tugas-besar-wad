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
        Schema::create('matching', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lost_id')->constrained('lost')->onDelete('cascade');
            $table->foreignId('found_id')->constrained('found')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'cocok', 'tidak cocok'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matching');
    }
};
