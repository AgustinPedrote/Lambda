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

    /* Filtros */
    public $selectedCategories = [];
    public $selectedLevels = [];
    public $selectedPrices = [];

    /* Buscador */
    public $search;

    /* Método mágico de livewire */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->categories = Category::all();
        $this->levels = Level::all();
    }

    public function render()
    {
        $courses = Course::where('status', CourseStatus::PUBLICADO)
            ->when($this->selectedCategories, function ($query) {
                $query->whereIn('category_id', $this->selectedCategories);
            })
            ->when($this->selectedLevels, function ($query) {
                $query->whereIn('level_id', $this->selectedLevels);
            })
            ->when($this->selectedPrices, function ($query) {
                if (count($this->selectedPrices) == 1) {
                    if ($this->selectedPrices[0] == 'free') {
                        $query->where('price_id', 1);
                    } else {
                        $query->where('price_id', '!=', 1);
                    }
                }
            })
            ->when($this->search, function ($query) {
                $query->where('title', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(6);

        return view('livewire.course-filter', compact('courses'));
    }
}
