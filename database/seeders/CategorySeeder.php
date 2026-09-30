<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Seminar',  'slug' => 'seminar'],
            ['name' => 'Workshop', 'slug' => 'workshop'],
            ['name' => 'Lomba',    'slug' => 'lomba'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}