<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'System Director',
            'email' => 'director@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Unit Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $director = User::where('email', 'director@example.com')->first();

        Division::create([
            'name' => 'Air Navigation Services',
            'abbr' => 'ANS',
            'director_id' => $director?->id,
        ]);

        Division::create([
            'name' => 'Safety & Standards',
            'abbr' => 'SAF',
            'director_id' => null,
        ]);

        $ans = Division::where('abbr', 'ANS')->first();
        $manager = User::where('email', 'manager@example.com')->first();

        Unit::create([
            'designator' => 'WMKK',
            'name' => 'KLIA ATC',
            'div_id' => $ans?->id,
            'address' => 'Kuala Lumpur International Airport',
            'phone' => '03-87770000',
            'afs' => 'KLIA',
            'manager_id' => $manager?->id,
        ]);

        Unit::create([
            'designator' => 'WMSA',
            'name' => 'Subang ATC',
            'div_id' => $ans?->id,
            'manager_id' => null,
        ]);

        $klia = Unit::where('designator', 'WMKK')->first();

        User::where('email', 'manager@example.com')->update([
            'unit_id' => $klia?->id,
        ]);

        User::where('email', 'user@example.com')->update([
            'unit_id' => $klia?->id,
        ]);
    }
}
