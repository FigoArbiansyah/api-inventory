<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'name' => 'Laptop ASUS X512',
            'sku' => 'ASUSX512',
            'description' => '15.6" laptop with Intel Core i5 processor and 8GB RAM.',
            'quantity' => 10,
            'price' => 700,
            'category_id' => 1, // Electronics
            'location_id' => 1, // Warehouse A
            'supplier_id' => 1, // ABC Supplier
            'reorder_level' => 5,
            'image' => 'path/to/image1.jpg',
        ]);

        Item::create([
            'name' => 'Office Chair',
            'sku' => 'OFFICECHAIR001',
            'description' => 'Ergonomic office chair with adjustable armrests and lumbar support.',
            'quantity' => 20,
            'price' => 150,
            'category_id' => 2, // Furniture
            'location_id' => 2, // Warehouse B
            'supplier_id' => 2, // XYZ Supplier
            'reorder_level' => 10,
            'image' => 'path/to/image2.jpg',
        ]);
    }
}
