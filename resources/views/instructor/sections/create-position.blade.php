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
    <div x-show="open" x-cloak class="mt-6"> {{-- Soluciona el parpadeo --}}
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
