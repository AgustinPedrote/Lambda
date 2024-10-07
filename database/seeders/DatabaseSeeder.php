<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Agustín Pedrote',
            'email' => 'agustin@agustin.com',
            'password' => bcrypt('12345678')
        ]);

        $this->call([
            CategorySeeder::class,
            LevelSeeder::class,
            PriceSeeder::class,
        ]);
    }
}
