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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('from_currency', 3); // CDF
            $table->string('to_currency', 3);   // USD
            $table->decimal('rate', 10, 6);     // Taux de change (ex: 0.000370)
            $table->decimal('inverse_rate', 10, 2); // Taux inverse (ex: 2700.00)
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
