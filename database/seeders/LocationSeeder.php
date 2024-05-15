<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'name' => 'Warehouse A',
            'description' => 'Main warehouse location',
        ]);

        Location::create([
            'name' => 'Warehouse B',
            'description' => 'Secondary warehouse location',
        ]);
    }
}
