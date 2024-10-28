<div>
    {{-- Listar secciones --}}
    <ul class="mb-6 space-y-6">
        @foreach ($sections as $section)
            <li>
                <div class="bg-gray-100 rounded-lg shadow-lg px-6 py-4">
                    <div class="md:flex md:items-center">
                        <h1 class="md:flex-1 truncate"> {{-- Esta clase hace que el texto siga con "..." --}}
                            Sección {{ $section->position }}:
                            <br class="md:hidden">
                            <span class="font-semibold">
                                {{ $section->name }}
                            </span>
                        </h1>

                        <div class="space-x-3 md:shrink-0 md:ml-4"> {{-- Esta clase hace que no se encoja los iconos --}}
                            <button>
                                <i class="fas fa-edit hover:text-indigo-600"></i>
                            </button>

                            <button>
                                <i class="far fa-trash-alt hover:text-red-600"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- Crear nueva sección --}}
    <form wire:submit="store">
        <div class="bg-gray-100 rounded-lg shadow-lg p-6">
            <x-label>
                Nueva sección
            </x-label>

            <x-input wire:model="name" class="w-full" placeholder="Ingrese el nombre de la sección" />

            <x-input-error for="name" />

            <div class="flex justify-end mt-4">
                <x-button>
                    Agregar sección
                </x-button>
            </div>
        </div>
    </form>
</div>
