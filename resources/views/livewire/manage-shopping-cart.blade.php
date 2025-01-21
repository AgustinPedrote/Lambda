<div>
    <h1 class="text-xl font-semibold mb2">
        Carrito de compras
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-12">
        <div class="order-2 lg:order-1 col-span-1 lg:col-span-3">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-2">
                <ul class="space-y-4">
                    @forelse (Cart::instance('shopping')->content() as $item)
                        <li class="lg:flex">
                            <figure class="w-full lg:w-40 lg:shrink-0"> {{-- Para que la imagen no cambie de tamaño --}}
                                <img src="{{ $item->options->image }}"
                                    class="w-full aspect-video object-conver rounded-lg ">
                            </figure>

                            <div class="lg:flex-1 lg:ml-4 overflow-hidden">
                                <h2 class="font-semibold truncate"> {{-- Para que no ocupe mas de una línea --}}
                                    <a href="">
                                        {{ $item->name }}
                                    </a>
                                </h2>

                                <p class="text-gray-500">
                                    {{ $item->options->teacher }}
                                </p>

                                <p class="font-semibold">
                                    {{ number_format($item->price, 2) }} €
                                </p>
                            </div>

                            <div wire:click="remove('{{ $item->rowId }}')" class="ml-6">
                                <button class="text-sm text-red-600 font-bold">
                                    Eliminar
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-500">
                            No hay productos en el carrito. <a href="{{ route('courses.index') }}" class="text-blue-500 hover:text-blue-600">Ver todos los cursos</a>
                        </li>
                    @endforelse
                </ul>
            </div>

            @if (Cart::instance('shopping')->count())
                <button wire:click="destroy" class="font-semibold text-red-500 text-sm">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Vaciar el carrito de compras
                </button>
            @endif
        </div>

        <div class="order-1 lg:order-2 col-span-1 lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-2">
                    Resumen
                </h2>

                <div class="flex justify-between items-center">
                    <p class="text-xl">
                        Total:
                    </p>

                    <p class="text-lg">
                        {{ number_format(Cart::instance('shopping')->subtotal(), 2) }} €
                    </p>
                </div>

                <div class="mt-4">
                    @if (Cart::instance('shopping')->count())
                        <a href="{{ route('checkout.index') }}" class="btn btn-red block w-full text-center uppercase">
                            Proceder con el pago
                        </a>
                    @else
                        <button disabled class="btn btn-red block w-full text-center uppercase disabled:opacity-50">
                            Proceder con el pago
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
