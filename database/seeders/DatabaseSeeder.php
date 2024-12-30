<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* Eliminar la carpeta 'courses' */
        Storage::deleteDirectory('courses');

        /* Crea las carpetas 'courses' e 'images' ya que faker no tiene la capacidad de crear carpetas */
        Storage::makeDirectory('courses/images');

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
            CourseSeeder::class,
        ]);
    }
}
