<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Lesson;
use App\Models\Section;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageSections extends Component
{
    public $course;
    public $name;
    public $sections; # Es el encargado de mostrar las secciones

    public $sectionEdit = [
        'id' => null,
        'name' => null
    ];

    public $sectionPositionCreate = [];

    public $orderLessons;

    # Se ejecuta cada vez que inicio el componente
    public function mount()
    {
        $this->getSections();
    }

    #[On('refreshOrderLessons')]
    # Para actualizar la información
    public function getSections()
    {
        $this->sections = Section::where('course_id', $this->course->id)
            ->with(['lessons' => function ($query) { /* Función callback */
                $query->orderBy('position', 'asc');
            }])
            ->orderBy('position', 'asc')
            ->get();

        /* Muestra solo la información de lessons */
        $this->orderLessons = $this->sections
            ->pluck('lessons')
            ->collapse() /* Combinar las lecciones de todos los arrays en uno */
            ->pluck('id');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required'
        ]);

        $this->course->sections()->create([
            'name' => $this->name
        ]);

        $this->getSections();

        $this->reset('name');
    }

    public function storePosition($sectionId)
    {
        $this->validate([
            "sectionPositionCreate.{$sectionId}.name" => 'required'
        ]);

        $position = Section::find($sectionId)->position;
        Section::where('course_id', $this->course->id)
            ->where('position', '>=', $position)
            ->increment('position');

        $this->course->sections()->create([
            'name' => $this->sectionPositionCreate[$sectionId]['name'],
            'position' => $position
        ]);

        $this->getSections();

        $this->reset("sectionPositionCreate"); /* Resetea todo */

        $this->dispatch('close-section-position-create');
    }

    public function edit(Section $section)
    {
        $this->sectionEdit = [
            'id' => $section->id,
            'name' => $section->name
        ];
    }

    public function update()
    {
        $this->validate([
            'sectionEdit.name' => 'required'
        ]);

        Section::find($this->sectionEdit['id'])->update([
            'name' => $this->sectionEdit['name']
        ]);

        $this->reset('sectionEdit');

        $this->getSections();
    }

    public function destroy(Section $section)
    {
        $section->delete();

        $this->getSections();

        # Disparar alerta
        $this->dispatch(
            'swal',
            [
                "icon" => "success",
                "title" => "¡Eliminado!",
                " text" => "La sección ha sido eliminada",
            ]
        );
    }

    public function sortSections($sorts)
    {
        foreach ($sorts as $position => $sectionId) {
            Section::find($sectionId)->update([
                'position' => $position + 1
            ]);

            $this->getSections();
        }
    }

    #[On('sortLessons')]
    public function sortLessons($sorts, $sectionId) /* Orden y sección a la que pertenece */
    {
        /* dd($sorts); */

        foreach ($sorts as $position => $lessonId) {
            Lesson::find($lessonId)->update([
                'position' => $position + 1,
                'section_id' => $sectionId
            ]);
        }

        $this->getSections();
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-sections');
    }
}
