<?php

namespace App\Livewire\Instructor\Courses;

use App\Events\VideoUploaded;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpParser\Node\Stmt\If_;

class ManageLessonContent extends Component
{
    /* Para poder subir videos en la aplicacíon */
    use WithFileUploads;

    public $lesson;

    public $editVideo = false;
    public $platform = 1, $video, $url;

    public $editDescription = false;
    public $description;

    public $is_published, $is_preview;

    /* Esta función se ejecuta cuando se carga el componente */
    public function mount($lesson)
    {
        $this->description = $lesson->description;
        $this->is_published = $lesson->is_published;
        $this->is_preview = $lesson->is_preview;
    }

    /* por defecto. no se ejecuta la función hasta que se ejecute algún metodo en específico */
    public function updated($property, $value)
    {
        if ($property == 'is_published') {
            $this->lesson->is_published = $value;
            $this->lesson->save();
        }

        if ($property == 'is_preview') {
            $this->lesson->is_preview = $value;
            $this->lesson->save();
        }
    }

    /* Esta función es una combinación de rules y store en ManageLessons.php */
    public function saveVideo()
    {
        $rules = [
            'platform' => 'required',
        ];

        if ($this->platform == 1) {
            $rules['video'] = 'required|mimes:mp4,mov,avi,wmv,flv,3gp';
        } else {
            $rules['url'] = ['required', 'regex:/^(?:https?:\/\/)?(?:www\.)?(youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]{10,12})/'];
        }

        $this->validate($rules);

        if ($this->lesson->platform == 1) {
            Storage::delete($this->lesson->video_path);
            Storage::delete($this->lesson->image_path);
        }

        $this->lesson->platform = $this->platform;
        $this->lesson->is_processed = false;

        if ($this->platform == 1) {
            $this->lesson->video_original_name = $this->video->getClientOriginalName();
            $this->lesson->save();

            $this->dispatch('uploadVideo', $this->lesson->id)->self(); /* Método 'self' para que escuche solo el componente indicado */
        } else {
            $this->lesson->video_original_name = $this->url;
            $this->lesson->save();

            /* Disparar el evento */
            VideoUploaded::dispatch($this->lesson);
        }

        /* Resetear valores */
        $this->reset('editVideo', 'platform', 'url');
    }

    public function saveDescription()
    {
        $this->lesson->description = $this->description;
        $this->lesson->save();

        $this->reset('editDescription');
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
        return view('livewire.instructor.courses.manage-lesson-content');
    }
}
