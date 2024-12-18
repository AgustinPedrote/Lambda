{{-- Esperamos recibir un parámetro --}}
@props(['label' => ''])

<button wire:ignore {{-- Para que si lo renderiza Livewire no haya ningún problema --}}
    class="flex items-center"
    x-data="{
    active: @entangle($attributes->wire('model')).live, {{-- Comunicación en tiempo real con el componente (update) --}}
    {{-- Enlazamos con el componente Livewire --}}
}" x-on:click="active = !active">
    <!-- El botón alterna el valor de 'active' -->

    <i class="fas text-2xl"
        :class="{ // Clase dinánmica
            'fa-toggle-on text-blue-600': active,
            'fa-toggle-off text-gray-600': !active,
        }">
    </i>

    <span class="text-sm ml-2">
        {{ $label }}
    </span>
</button>
