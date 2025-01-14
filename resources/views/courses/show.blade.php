<x-app-layout>

    <x-container class="mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="col-span-1 lg:col-span-2 order-2 lg:order-1">
                {{-- Portada --}}
                <div class="mb-8">
                    <h1 class="text-3xl font-semibold mb-1">
                        {{ $course->title }}
                    </h1>

                    <p class="mb-2">
                        {{ $course->summary }}
                    </p>

                    <figure>
                        <img class="w-full aspect-video object-cover object-center" src="{{ $course->image }}"
                            alt="">
                    </figure>
                </div>

                {{-- Objetivos --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">
                        Objetivos del curso
                    </h2>

                    <div class="bg-white rounded-lg shadow p-6">
                        <ul class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-gray-800">
                            @foreach ($course->goals as $goal)
                                <li class="flex space-x-4">
                                    <i class="fa-regular fa-circle-check text-lg"></i>

                                    <p>
                                        {{ $goal->name }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Curriculum --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">
                        Temario del curso
                    </h2>

                    <ul class="space-y-4">
                        @foreach ($course->sections as $section)
                            {{-- Alpine --}}
                            <li x-data="{
                                open: false
                            }">
                                <div class="bg-white rounded-lg">
                                    <button x-on:click="open = !open"
                                        class="flex w-full p-4 bg-gray-50 text-left border-b">
                                        <span class="text-xl font-semibold">
                                            {{ $section->name }}
                                        </span>

                                        <span class="ml-auto">
                                            {{ $section->lessons->count() }} clases
                                        </span>
                                    </button>

                                    <div class="p-4" x-show="open" x-cloak>
                                        <ul>
                                            @foreach ($section->lessons as $lesson)
                                                <li class="flex">
                                                    <a href="" class="flex">
                                                        <i class="far fa-play-circle text-blue-500 mt-0.5 mr-2"></i>
                                                    </a>

                                                    <span
                                                        class="font-semibold text-gray-600 hover:text-blue-800 text-sm">
                                                        {{ $lesson->name }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Requerimientos --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">
                        Requisitos del curso
                    </h2>

                    <ul class="list-disc list-inside">
                        @foreach ($course->requirements as $requirement)
                            <li>
                                {{ $requirement->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Descripción --}}
                <div>
                    <h2 class="text-2xl font-semibold mb-4">
                        Descripción
                    </h2>

                    <div>
                        {{ $course->description }}
                    </div>
                </div>
            </div>

            <div class="col-span-1 order-1 lg:order-2">
                <div class="bg-white rounded-lg shadow p-6"> {{-- Tarjeta --}}
                    <div class="mb-4">
                        {{-- Policies --}}
                        @can('enrolled', $course)
                            <p class="flex items-cente mb-2">
                                <i class="fas fa-info-circle inline-block w-6 flex-shrink-0"></i>

                                <span class="font-semibold leading-none"> {{-- Alinea icono y texto --}}
                                    Adquirido el {{ $course->dateOfAcquisition }}
                                </span>
                            </p>

                            <a href="{{ route('courses.status', $course) }}"
                                class="btn btn-red block text-center uppercase w-full">
                                Continuar con el curso
                            </a>
                        @else
                            {{-- Precio --}}
                            <p class="font-semibold text-2xl text-center mb-2">
                                @if ($course->price->value == 0)
                                    <span class="text-green-500">
                                        Gratis
                                    </span>
                                @else
                                    <span class="text-gray-700">
                                        {{ number_format($course->price->value, 2) }} €
                                    </span>
                                @endif
                            </p>

                            @livewire('course-enrolled', ['course' => $course])
                        @endcan

                    </div>

                    {{-- Detalles del curso --}}
                    <div>
                        <p class="font-semibold text-lg mb-1">
                            Detalles del curso:
                        </p>

                        <ul class="space-y-1">
                            {{-- Para cambiar el tamaño de un icono hay que utilizar el 'inline-block' --}}
                            <li>
                                <i class="far fa-calendar-alt inline-block w-6"></i> Última actualización
                                {{ $course->updated_at->format('d/m/Y') }}
                            </li>

                            <li>
                                <i class="far fa-clock inline-block w-6"></i> Duración: 3.7 horas
                            </li>

                            <li>
                                <i class="fas fa-chart-line inline-block w-6"></i> {{ $course->level->name }}
                            </li>

                            <li>
                                <i class="fas fa-star inline-block w-6"></i> Calificación: 5
                            </li>

                            <li>
                                <i class="fas fa-infinity inline-block w-6"></i> Acceso de por vida
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-container>

</x-app-layout>
