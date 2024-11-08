<?php

namespace App\Observers;

use App\Models\Section;

class SectionObserver
{
    # Esta función se realiza antes de crear una sección
    public function creating(Section $section)
    {
        /* Remplazar el valor de 'position' por el último, solo en el caso de que no tenga nada en el campo 'position */
        if (!$section->position) {
            $section->position = Section::where('course_id', $section->course_id)->max('position') + 1;
        }
    }
}
