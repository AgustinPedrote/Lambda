<?php

namespace App\Livewire\Instructor\Courses;

use App\Events\VideoUploaded;
use App\Models\Lesson;
use App\Rules\UniqueLessonCourse;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageLessons extends Component
{
    /* Para poder subir videos en la aplicacíon */
    use WithFileUploads;

    public $section;
    public $lessons;

    public $video, $url;
    public $lessonCreate = [
        'open' => false,
        'name' => null,
        /* 'slug' => null, */
        'platform' => 1,
        /* 'video_path' => null, */
        'video_original_name' => null
    ];

    public $lessonEdit = [
        'id' => null,
        'name' => null,
    ];

    /* Refrescar información de lecciones */
    public function getLessons()
    {
        $this->lessons = Lesson::where('section_id', $this->section->id)
            ->orderBy('position', 'asc')
            ->get();
    }

    /* Al crear una nueva lección se generan las reglas dinámicamente */
    public function rules()
    {
        $rules = [
            'lessonCreate.name' => ['required', new UniqueLessonCourse($this->section->course_id)], /* Regla de validacion personalizada */
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

            /* Disparar el evento */
            VideoUploaded::dispatch($lesson);
        }

        $this->reset(['url', 'lessonCreate']);

        $this->getLessons();
    }

    public function edit($lessonId)
    {
        $lesson = Lesson::find($lessonId);

        $this->lessonEdit = [
            'id' => $lesson->id,
            'name' => $lesson->name,
        ];
    }

    public function update()
    {
        $this->validate([
            'lessonEdit.name' => ['required'],
        ]);

        Lesson::find($this->lessonEdit['id'])->update([
            'name' => $this->lessonEdit['name'],
        ]);

        $this->reset('lessonEdit');

        /* Para que se vean reflejados los cambios sin necesidad de refrescar la página */
        $this->getLessons();
    }

    public function destroy($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        $lesson->delete();

        $this->getLessons();
    }

    /* El evento se recepciona aquí */
    #[On('uploadVideo')]
    public function uploadVideo($lessonId)
    {
        $lesson = Lesson::find($lessonId); /* Busco la lección por el Id y asi ya puedo tratarlo como un objeto */

        $lesson->video_path = $this->video->store('courses/lessons');
        $lesson->save();

        /* Disparar el evento */
        VideoUploaded::dispatch($lesson);

        $this->reset('video');
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}
