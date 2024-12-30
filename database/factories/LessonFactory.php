<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'platform' => 2,
            'video_path' => 'sla7hGaTotU',
            'video_original_name' => 'https://youtu.be/sla7hGaTotU?si=Zb2xRp8baC6Doqm_',
            'image_path' => 'https://img.youtube.com/vi/sla7hGaTotU/0.jpg',
            'description' => $this->faker->paragraph,
            'duration' => 3633,
            'is_processed' => 1
        ];
    }
}
