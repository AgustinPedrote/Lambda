<?php

namespace App\Observers;

use App\Models\Lesson;

class LessonObserver
{
    # Esta función se realiza antes de crear una lección
    public function creating(Lesson $lesson)
    {
        $lesson->position = Lesson::where('section_id', $lesson->section_id)->max('position') + 1;
    }
}
