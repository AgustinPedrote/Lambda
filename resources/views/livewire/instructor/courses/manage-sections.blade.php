<div x-data="{
    {{-- Método para confirmar la eliminación de una sección --}}
    destroySection(sectionId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, bórralo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                {{-- Llama al método destroy en el backend usando Livewire --}}
                @this.call('destroy', sectionId);
            }
        });
    }
}">

    {{-- Listar secciones --}}
    @if ($sections->count()) {{-- Verifica si hay secciones para mostrar --}}
        <ul class="mb-6 space-y-6">
            @foreach ($sections as $section)
                <div x-data="{
                    {{-- Controla la apertura del formulario de cada sección --}}
                    {{-- Alpine --}}
                    open: false
                }" x-on:close-section-position-create.window="open = false">
                    {{-- Escucha cualquier evento que produzca algún componente Livewire dentro del div, con 'window' permite hacerlo desde cualquier componente --}}

                    {{-- Botón de despliegue para cada sección --}}
                    <div x-data="{
                        open: false
                    }" x-on:close-section-position-create.window="open = false">
                        <div x-on:click="open = !open"
                            class="h-6 w-12 -ml-4 bg-indigo-50 hover:bg-indigo-200 flex items-center justify-center cursor-pointer"
                            style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">

                            {{-- Icono que rota cuando se abre el formulario --}}
                            <i class="-ml-2 text-sm fas fa-plus transition duration-300"
                                :class="{
                                    'transform rotate-45': open,
                                    'transform rotate-0': !open
                                }"></i>
                        </div>

                        {{-- Formulario para crear una nueva posición en la sección seleccionada --}}
                        <div x-show="open" x-cloak class="mt-6">
                            <form wire:submit="storePosition({{ $section->id }})">
                                <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                                    <x-label>
                                        Nueva sección
                                    </x-label>

                                    {{-- Input para el nombre de la nueva sección --}}
                                    <x-input wire:model="sectionPositionCreate.{{ $section->id }}.name" class="w-full"
                                        placeholder="Ingrese el nombre de la sección" />
                                    <x-input-error for="sectionPositionCreate.{{ $section->id }}.name" />

                                    <div class="flex justify-end mt-4">
                                        <div class="space-x-2">
                                            <x-danger-button x-on:click="open = false">
                                                Cancelar
                                            </x-danger-button>

                                            <x-button>
                                                Agregar
                                            </x-button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Otra instancia de formulario de sección con comportamiento similar --}}
                    <div x-show="open" x-cloak class="mt-4"> {{-- Soluciona el parpadeo --}}
                        <form>
                            <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                                <x-label>
                                    Nueva sección
                                </x-label>

                                <x-input class="w-full" placeholder="Ingrese el nombre de la sección" />

                                <x-input-error for="name" />

                                <div class="flex justify-end mt-4">
                                    <x-button>
                                        Agregar sección
                                    </x-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Lista de secciones con Livewire key para optimizar el renderizado --}}
                <li wire:key="section-{{ $section->id }}"> {{-- IMPORTANTE para que livewire pueda seguir un correcto seguimiento --}}
                    <div class="bg-gray-100 rounded-lg shadow-lg px-6 py-4">
                        @if ($sectionEdit['id'] == $section->id)
                            {{-- Formulario para editar el nombre de la sección --}}
                            <form wire:submit="update">
                                <div class="flex items-center space-x-2">
                                    <x-label>
                                        Sección {{ $section->position }}:
                                    </x-label>

                                    <x-input wire:model="sectionEdit.name" class="flex-1" />
                                </div>

                                <div class="flex justify-end mt-4">
                                    <div class="space-x-2">
                                        <x-danger-button wire:click="$set('sectionEdit.id', null)">
                                            Cancelar
                                        </x-danger-button>

                                        <x-button>
                                            Actualizar
                                        </x-button>
                                    </div>
                                </div>
                            </form>
                        @else
                            {{-- Vista de la sección y botones de acción --}}
                            <div class="md:flex md:items-center">
                                <h1 class="md:flex-1 truncate"> {{-- Esta clase hace que el texto siga con "..." --}}
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
                        @endif

                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Para que el formulario permanezca cerrado --}}
    <div x-data="{
        open: false
    }">
        <div x-on:click="open = !open"
            class="h-6 w-12 -ml-4 bg-indigo-50 hover:bg-indigo-200 flex items-center justify-center cursor-pointer"
            style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">

            {{-- Icono que rota cuando se abre el formulario --}}
            <i class="-ml-2 text-sm fas fa-plus transition duration-300"
                :class="{
                    'transform rotate-45': open,
                    'transform rotate-0': !open
                }"></i>
        </div>

        {{-- Formulario para crear una nueva sección --}}
        <div x-show="open" x-cloak class="mt-4">
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
    </div>
</div>
