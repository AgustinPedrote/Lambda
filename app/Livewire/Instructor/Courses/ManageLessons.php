<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Component;
use Livewire\WithFileUploads;

class ManageLessons extends Component
{
    /* Para poder subir videos en la aplicacíon */
    use WithFileUploads;

    public $section;
    public $lesson;

    public $video, $url;
    public $lessonCreate = [
        'open' => false,
        'name' => null,
        'slug' => null,
        'platform' => 1,
        'video_path' => null,
        'video_original_name' => null
    ];

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}
