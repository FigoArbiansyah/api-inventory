<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'ABC Supplier',
            'contact_person' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'address' => '123 Main Street, City, Country',
        ]);

        Supplier::create([
            'name' => 'XYZ Supplier',
            'contact_person' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'phone' => '+0987654321',
            'address' => '456 Elm Street, City, Country',
        ]);
    }
}
