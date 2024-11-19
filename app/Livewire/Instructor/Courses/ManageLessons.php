<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Lesson;
use Livewire\Attributes\On;
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
        /* 'slug' => null, */
        'platform' => 1,
        /* 'video_path' => null, */
        'video_original_name' => null
    ];

    /* Al crear una nueva lección se generan las reglas dinámicamente */
    public function rules()
    {
        $rules = [
            'lessonCreate.name' => 'required',  /* ['required', new UniqueLessonCourse($this->section->course_id)] */
            'lessonCreate.platform' => 'required',
        ];

        if ($this->lessonCreate['platform'] == 1) {
            $rules['video'] = 'required|mimes:mp4,mov,avi,wmv,flv,3gp';
        } else {
            $rules['url'] = ['required', 'regex:/^(?:https?:\/\/)?(?:www\.)?(youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]{10,12})/'];
        }

        return $rules;
    }

    /* Aplicamos la validación y dependiendo de la plataforma que estamos trabajando se ejecuta una acción u otra */
    public function store()
    {
        $this->validate();

        if ($this->lessonCreate['platform'] == 1) {

            $this->lessonCreate['video_original_name'] = $this->video->getClientOriginalName();
            $lesson = $this->section->lessons()->create($this->lessonCreate);

            $this->dispatch('uploadVideo', $lesson->id)->self(); /* Método 'self' para que escuche solo el componente indicado */
        } elseif ($this->lessonCreate['platform'] == 2) {

            $this->lessonCreate['video_original_name'] = $this->url/* ->getClientOriginalName() */;
            $lesson = $this->section->lessons()->create($this->lessonCreate);
        }

        $this->reset(['url', 'lessonCreate']);
    }

    /* El evento se recepciona aquí */
    #[On('uploadVideo')]
    public function uploadVideo($lessonId)
    {
        $lesson = Lesson::find($lessonId); /* Busco la lección por el Id y asi ya puedo tratarlo como un objeto */

        $lesson->video_path = $this->video->store('courses/lessons');
        $lesson->save();

        $this->reset('video');
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}
