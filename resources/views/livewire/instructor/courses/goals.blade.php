<div>

    <ul class="space-y-2 mb-4">
        @foreach ($goals as $index => $goal)
            <li wire:key="goal-{{ $goal['id'] }}">

                <x-input wire:model="goals.{{ $index }}.name" class="w-full" />

            </li>
        @endforeach
    </ul>

    <div class="flex justify-end mb-8">
        <x-button wire:click="update">
            Actualizar
        </x-button>
    </div>

    <form wire:submit="store">
        <div class="bg-gray-100 rounded-lg shadow-lg p-6">
            <x-label>
                Nueva meta
            </x-label>

            <x-input wire:model="name" class="w-full" placeholder="Ingrese el nombre de la meta" />

            <x-input-error for="name" />

            <div class="flex justify-end mt-4">
                <x-button>
                    Agregar meta
                </x-button>
            </div>
        </div>
    </form>

</div>
