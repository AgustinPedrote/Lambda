<?php

namespace App\Observers;

use App\Models\Lesson;
use Illuminate\Support\Str; /* Para crear Slug */

class LessonObserver
{
    # Esta función se realiza antes de crear una lección
    public function creating(Lesson $lesson)
    {
        $lesson->position = Lesson::where('section_id', $lesson->section_id)->max('position') + 1;

        $lesson->slug = Str::slug($lesson->name); /* Pasar el titulo a cadena separada por guiones */
    }
}
