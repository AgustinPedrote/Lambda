<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Requirement;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Symfony\Contracts\Service\Attribute\Required;

class Requirements extends Component
{
    public $course;

    public $requirements;

    #[Validate('required|string|max:255')]
    public $name;

    public function mount()
    {
        $this->requirements = Requirement::where('course_id', $this->course->id)
            ->orderBy('position', 'asc')
            ->get()
            ->toArray();
    }

    public function store()
    {
        $this->validate();

        $this->course->requirements()->create([
            'name' => $this->name
        ]);

        # Consulta en la BBDD y refrescas la propiedad para que así se agrege la meta sin necesidad de refrescar la página.
        $this->requirements = Requirement::where('course_id', $this->course->id)
            ->orderBy('position', 'asc')
            ->get()
            ->toArray();

        $this->reset('name');
    }

    public function update()
    {
        $this->validate([
            'requirements.*.name' => 'required|string|max:255'
        ]);

        foreach ($this->requirements as $requirement) {
            Requirement::find($requirement['id'])->update([
                'name' => $requirement['name']
            ]);
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Los requerimientos se han actualizado correctamente'
        ]);
    }

    public function destroy($requiredId)
    {
        Requirement::find($requiredId)->delete();

        $this->requirements = Requirement::where('course_id', $this->course->id)
            ->orderBy('position', 'asc')
            ->get()
            ->toArray();
    }

    public function sortRequirements($data)
    {
        /* dd($data); */

        foreach ($data as $index => $requirementId) {
            Requirement::find($requirementId)->update([
                'position' => $index + 1
            ]);
        }

        # Refrescar la información de las metas
        $this->requirements = Requirement::where('course_id', $this->course->id)
            ->orderBy('position', 'asc')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.instructor.courses.requirements');
    }
}
