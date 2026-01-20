<?php

namespace Database\Seeders;

use App\Models\RiskRating;
use App\Models\HazardScope;
use App\Models\HazardSource;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HazardLookupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'Audit','Investigation','Safety Risk Assessment','Safety Review',
            'Mandatory Occurrence Report','Voluntary Occurrence Report','NOSS'
        ] as $i => $name) {
            HazardSource::firstOrCreate(['name' => $name], ['sort_order' => $i, 'is_active' => true]);
        }

        foreach (['Area','Operation','Equipment','Procedure','Activity','Human Factor'] as $i => $name) {
            HazardScope::firstOrCreate(['name' => $name], ['sort_order' => $i, 'is_active' => true]);
        }

        // foreach (['Catastrophic','Hazardous','Major','Minor','Negligible'] as $i => $name) {
        //     RiskRating::firstOrCreate(['name' => $name], ['sort_order' => $i, 'is_active' => true]);
        // }
    }
}
