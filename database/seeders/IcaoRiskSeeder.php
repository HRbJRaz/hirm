<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiskSeverity;
use App\Models\RiskProbability;

class IcaoRiskSeeder extends Seeder
{
    public function run(): void
    {
        $severities = [
            ['code' => 'A', 'name' => 'Catastrophic'],
            ['code' => 'B', 'name' => 'Hazardous'],
            ['code' => 'C', 'name' => 'Major'],
            ['code' => 'D', 'name' => 'Minor'],
            ['code' => 'E', 'name' => 'Negligible'],
        ];

        foreach ($severities as $i => $s) {
            RiskSeverity::firstOrCreate(
                ['code' => $s['code']],
                ['name' => $s['name'], 'sort_order' => $i, 'is_active' => true]
            );
        }

        $probabilities = [
            ['value' => 5, 'name' => 'Frequent'],
            ['value' => 4, 'name' => 'Occasional'],
            ['value' => 3, 'name' => 'Remote'],
            ['value' => 2, 'name' => 'Improbable'],
            ['value' => 1, 'name' => 'Extremely Improbable'],
        ];

        foreach ($probabilities as $i => $p) {
            RiskProbability::firstOrCreate(
                ['value' => $p['value']],
                ['name' => $p['name'], 'sort_order' => $i, 'is_active' => true]
            );
        }
    }
}