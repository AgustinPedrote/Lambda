<div>
    @if ($course->price->value == 0)
        <button wire:click="enrolled" class="btn btn-red w-full uppercase">
            Inscribete ahora
        </button>
    @else
        @if (Cart::instance('shopping')->content()->where('id', $course->id)->first())
            {{-- Cuando hay dos elementos similares es mas conveniente crear una key para livewire --}}
            <button wire:key="removeCart" wire:click="removeCart" class="btn btn-blue w-full uppercase mb-2">
                Eliminar del carrito
            </button>
        @else
            <button wire:key="addCart" wire:click="addCart" class="btn btn-blue w-full uppercase mb-2">
                Agregar al carrito
            </button>
        @endif

        <button wire:click="buyNow" class="btn btn-red w-full uppercase">
            Comprar ahora
        </button>
    @endif
</div>
