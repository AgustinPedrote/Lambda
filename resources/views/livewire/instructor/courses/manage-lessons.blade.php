<div>

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
