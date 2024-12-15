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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // "id" column
            $table->string('email')->unique(); // "email" column (unique)
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Foreign key to "customers"
            $table->timestamps(); // "created_at" and "updated_at" columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
