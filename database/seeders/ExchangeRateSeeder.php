<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le taux de change initial CDF vers USD
        ExchangeRate::create([
            'from_currency' => 'CDF',
            'to_currency' => 'USD',
            'rate' => 0.00037, // 1 CDF = 0.00037 USD
            'inverse_rate' => 2700.00, // 1 USD = 2700 CDF
            'is_active' => true,
            'last_updated' => now(),
        ]);

        $this->command->info('Taux de change initial créé : 1 USD = 2700 CDF');
    }
}
