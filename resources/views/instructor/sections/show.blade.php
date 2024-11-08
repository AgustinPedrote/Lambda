{{-- Vista de la sección y botones de acción --}}
<div class="md:flex md:items-center">
    <h1 class="md:flex-1 truncate handle cursor-move"> {{-- Esta clase hace que el texto siga con "..." --}}
        Sección {{ $loop->iteration }}: {{-- Indica el número de iteración --}}
        <br class="md:hidden">
        <span class="font-semibold">
            {{ $section->name }}
        </span>
    </h1>

    {{-- Botones para editar y eliminar la sección --}}
    <div class="space-x-3 md:shrink-0 md:ml-4"> {{-- Esta clase hace que no se encoja los iconos --}}
        <button wire:click="edit({{ $section->id }})">
            <i class="fas fa-edit hover:text-indigo-600"></i>
        </button>

        <button x-on:click="destroySection({{ $section->id }})">
            <i class="far fa-trash-alt hover:text-red-600"></i>
        </button>
    </div>
</div>
