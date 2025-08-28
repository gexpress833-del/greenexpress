<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added this import for DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Avant de rendre 'phone' non nullable, mettons à jour les valeurs nulles existantes.
            // Nous ne pouvons pas le faire directement ici car $table->string('phone')->nullable(false)->change();
            // est traité comme un seul statement SQL, ce qui poserait problème.
        });

        // Mise à jour des entrées existantes avant de modifier la colonne
        DB::table('users')->whereNull('phone')->update(['phone' => '']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change(); // Rendre obligatoire
            $table->string('profile_photo_path', 2048)->nullable(false)->default('default-avatar.png'); // Pour la photo de profil, rendu obligatoire avec une valeur par défaut
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->change(); // Revenir à nullable
            $table->dropColumn('profile_photo_path');
        });
    }
};
