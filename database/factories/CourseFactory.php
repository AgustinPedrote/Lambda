<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Level;
use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        // Ruta donde se generarán las imágenes
        $imageDirectory = 'public/storage/courses/images';

        // Asegúrate de que la carpeta existe
        if (!file_exists($imageDirectory)) {
            \Illuminate\Support\Facades\Storage::makeDirectory('courses/images');
        }

        // Intenta generar una imagen con Faker
        $imageName = $this->faker->image($imageDirectory, 640, 480, null, false);

        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'summary' => $this->faker->paragraph,
            'description' => $this->faker->text(2000),
            'status' => 3, // Publicado
            'image_path' => $imageName ? "courses/images/{$imageName}" : null, // Asigna null si no se genera la imagen
            'user_id' => 1,
            'level_id' => Level::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'price_id' => Price::all()->random()->id,
        ];
    }

    // El original pero fallan imagenes de faker

    /*  public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'status' => 3, //Publicado
            'image_path' => 'courses/images/' . $this->faker->image('public/storage/courses/images', 640, 480, null, false), //false solo retorna el nombre de la imagen
            'user_id' => 1,
            'level_id' => Level::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'price_id' => Price::all()->random()->id,
        ];
    } */
}
