<x-app-layout>
    <x-container class="mt-8">
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
                            </li>
                        @empty
                            <li class="text-gray-500">
                                No hay productos en el carrito
                            </li>
                        @endforelse
                    </ul>
                </div>
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

                    {{-- PayPal --}}
                    <div class="mt-4">

                        <div id="paypal-button-container"></div>

                    </div>
                </div>
            </div>
        </div>
    </x-container>

    @push('js')
        <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=EUR"
            data-sdk-integration-source="developer-studio"></script>

        <script>
            paypal.Buttons({

            }).render('#paypal-button-container');
        </script>
    @endpush
</x-app-layout>
