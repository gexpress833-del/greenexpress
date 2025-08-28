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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('name')->after('user_id');
            $table->decimal('normal_price_cdf', 10, 2)->after('price')->default(0);
            $table->decimal('subscription_price_cdf', 10, 2)->after('normal_price_cdf')->default(0);
            $table->integer('meal_count')->after('subscription_price_cdf')->default(0);
            $table->text('benefits')->nullable()->after('meal_count');
            $table->dropColumn('price'); // Suppression de l'ancienne colonne 'price'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->after('type'); // Réajout de l'ancienne colonne 'price'
            $table->dropColumn(['name', 'normal_price_cdf', 'subscription_price_cdf', 'meal_count', 'benefits']);
        });
    }
};
