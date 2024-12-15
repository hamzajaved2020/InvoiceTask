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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id(); // "id" column
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to "users"
            $table->date('activated')->nullable(); // "activated" column (nullable)
            $table->date('appointment')->nullable(); // "appointment" column (nullable)
            $table->timestamps(); // "created_at" and "updated_at" columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
