<?php

namespace App\Observers;

use App\Models\Section;

class SectionObserver
{
    # Esta función se realiza antes de crear una sección
    public function creating(Section $section)
    {
        $section->position = Section::where('course_id', $section->course_id)->max('position') + 1;
    }
}
