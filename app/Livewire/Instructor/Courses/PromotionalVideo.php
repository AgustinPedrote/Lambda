<?php

/* No se utiliza este archivo, la subida del video promocional se hace con el controlador */

namespace App\Livewire\Instructor\Courses;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class PromotionalVideo extends Component
{
    /* Para subir cualquier tipo de archivo */
    use WithFileUploads;

    public $course;

    #[Validate('required', 'mimeTypes:video/*')]
    public $video;

    public function save()
    {
        $this->validate();

        $this->course->video_path = $this->video->store('courses/promotional-videos');

        $this->course->save();
    }

    public function render()
    {
        return view('livewire.instructor.courses.promotional-video');
    }
}
