<div>

    <div x-data="{
        {{-- Método para confirmar la eliminación de una lección --}}
        destroyLesson(lessonId) {
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
                    @this.call('destroy', lessonId);
                }
            });
        }
    }" class="mb-6">
        <ul class="space-y-4">
            @foreach ($lessons as $lesson)
                <li wire:key="lesson-{{ $lesson->id }}"> {{-- Se recomienda en livewire usar llave para correcto seguimiento --}}
                    <div class="bg-white rounded-lg shadow-lg px-6 py-4">
                        @if ($lessonEdit['id'] == $lesson->id)
                            {{-- Formulario para editar el nombre de la lección --}}
                            <form wire:submit="update">
                                <div class="flex items-center space-x-2">
                                    <x-label>
                                        Lección:
                                    </x-label>

                                    <x-input wire:model="lessonEdit.name" class="flex-1" />
                                </div>

                                <div class="flex justify-end mt-4">
                                    <div class="space-x-2">
                                        <x-danger-button wire:click="$set('lessonEdit.id', null)">
                                            Cancelar
                                        </x-danger-button>

                                        <x-button>
                                            Actualizar
                                        </x-button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="md:flex md:items-center">
                                <h1 class="md:flex-1 truncate cursor-move">
                                    <i class="fas fa-play-circle text-blue-600"></i>
                                    Lección {{ $orderLessons->search($lesson->id) + 1 }}:
                                    {{ $lesson->name }}
                                </h1>

                                <div class="space-x-3 md:shrink-0 md:ml-4"> {{-- Esta clase hace que no se encoja los iconos --}}
                                    <button wire:click="edit({{ $lesson->id }})">
                                        <i class="fas fa-edit hover:text-indigo-600"></i>
                                    </button>

                                    <button x-on:click="destroyLesson({{ $lesson->id }})">
                                        <i class="far fa-trash-alt hover:text-red-600"></i>
                                    </button>

                                    <button>
                                        <i class="fas fa-chevron-down hover:text-blue-600"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Creación --}}
    <div x-data="{
        {{-- Vincular estas variables con los valores de "ManageLessons.php" --}}
        open: @entangle('lessonCreate.open'),
            platform: @entangle('lessonCreate.platform'),
    }">

        <div x-on:click="open = !open"
            class="h-6 w-12 -ml-4 bg-indigo-200 hover:bg-indigo-300 flex items-center justify-center cursor-pointer"
            style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">

            {{-- Icono que rota cuando se abre el formulario --}}
            <i class="-ml-2 text-sm fas fa-plus transition duration-300"
                :class="{
                    'transform rotate-45': open,
                    'transform rotate-0': !open
                }"></i>
        </div>

        <form wire:submit="store" class="mt-4 bg-white rounded-lg shadow-lg" x-show="open" x-cloak>
            <div class="p-6">
                <div class="mb-2">
                    <x-input wire:model="lessonCreate.name" class="w-full"
                        placeholder="Ingrese el nombre de la lección" />

                    <x-input-error for="lessonCreate.name" />
                </div>

                <div>
                    <x-label class="mb-1">
                        Plataformas
                    </x-label>

                    <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                        <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                            <button type="button"
                                class="inline-flex flex-col justify-center items-center w-full md:w-20 md:h-24 border rounded py-2"
                                :class="platform == 1 ? 'border-indigo-500 text-indigo-500' : 'border-gray-300'"
                                x-on:click="platform = 1">

                                <i class="fas fa-video text-2xl"></i>

                                <span class="text-sm mt-2">
                                    Video
                                </span>
                            </button>

                            <button type="button"
                                class="inline-flex flex-col justify-center items-center w-full md:w-20 md:h-24 border rounded py-2"
                                :class="platform == 2 ? 'border-indigo-500 text-indigo-500' : 'border-gray-300'"
                                x-on:click="platform = 2">

                                <i class="fab fa-youtube text-2xl"></i>

                                <span class="text-sm mt-2">
                                    Youtube
                                </span>
                            </button>
                        </div>

                        <p>
                            Primero debes elegir una plataforma para subir tu contenido
                        </p>
                    </div>

                    <div class="mt-2" x-show="platform == 1" x-cloak> {{-- x-cloak evita parpadeo --}}
                        <x-label>
                            Video
                        </x-label>

                        {{-- Componente livewire para seleccionar archivos --}}
                        <x-progress-indicators wire:model="video" />
                    </div>

                    <div class="mt-2" x-show="platform == 2" x-cloak>
                        <x-label>
                            Video
                        </x-label>

                        <x-input wire:model="url" placeholder="Ingrese la URL de Youtube" class="w-full" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end px-6 py-4 bg-gray-100" x-show="open" x-cloak>
                <x-danger-button x-on:click="open = false">
                    Cancelar
                </x-danger-button>

                <x-button wire:click="store" class="ml-2">
                    Guardar
                </x-button>
            </div>
        </form>

    </div>

</div>
