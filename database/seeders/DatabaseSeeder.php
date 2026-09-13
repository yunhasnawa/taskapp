<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Database\Factories\TaskFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin Kantor',
            'email' => 'admin@polinema.ac.id',
            'role' => 'admin',
        ]);

        $user1 = User::factory()->create([
            'name' => 'Yoppy Yunhasnawa',
            'email' => 'yunhasnawa@polinema.ac.id',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Atif Windawati',
            'email' => 'atif@polines.ac.id',
        ]);

        Task::factory(8)->for($user1)->create();
        Task::factory(2)->for($user1)->overdue()->create();
        Task::factory(5)->for($user2)->create();
        Task::factory(3)->for($admin)->create();
    }
}
