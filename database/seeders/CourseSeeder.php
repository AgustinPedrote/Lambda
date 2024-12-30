<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Goal;
use App\Models\Requirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Generar factories */
        Course::factory(20)->create()->each(function ($course) {
            Goal::factory(4)->create([
                'course_id' => $course->id
            ]);

            Requirement::factory(4)->create([
                'course_id' => $course->id
            ]);
        });
    }
}
