<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Pekerjaan', 'Pribadi', 'Belajar', 'Rumah Tangga'] as $name)
        {
            Category::query()->create(['name' => $name]);
        }
    }
}
