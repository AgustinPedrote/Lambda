<?php

namespace App\Livewire;

use App\Enums\CourseStatus;
use App\Models\Category;
use App\Models\Course;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;

class CourseFilter extends Component
{
    /* Mostrar paginado utilizando livewire */
    use WithPagination;

    public $categories;
    public $levels;

    public function mount()
    {
        $this->categories = Category::all();
        $this->levels = Level::all();
    }

    public function render()
    {
        $courses = Course::where('status', CourseStatus::PUBLICADO)
        ->paginate(6);

        return view('livewire.course-filter', compact('courses'));
    }
}
