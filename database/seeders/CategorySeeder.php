<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Food Delivery', 'description' => 'Food and restaurant deliveries'],
            ['name' => 'E-commerce', 'description' => 'Online shopping packages'],
            ['name' => 'Documents', 'description' => 'Important documents and letters'],
            ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Medicines', 'description' => 'Medical supplies and prescriptions'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}