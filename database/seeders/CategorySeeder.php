<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Listahan ng mga categories na gusto mong ilagay
        $categories = [
            ['name' => 'Technical Issue'],
            ['name' => 'Network & Connectivity'],
            ['name' => 'Software Installation'],
            ['name' => 'Hardware Repair'],
            ['name' => 'Account & Password'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}