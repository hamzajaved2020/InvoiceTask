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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // "id" column
            $table->date('start_date'); // "start_date" column
            $table->date('end_date'); // "end_date" column
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Foreign key to "customers"
            $table->decimal('total_prices', 10, 2); // "total_prices" column with precision
            $table->integer('total_events'); // "total_events" column
            $table->timestamps(); // "created_at" and "updated_at" columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
