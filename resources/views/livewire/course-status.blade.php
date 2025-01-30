<div>
    <div class="grid grid-cols-3 gap-8">
        <div class="col-span-2">
            <iframe class="w-full aspect-video" src="https://www.youtube.com/embed/{{ $current->video_path }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

            <h1 class="text-3xl font-semibold mt-4">
                {{ $lessons->search($current->id) + 1 }}. {{ $current->name }} {{-- 'search' retorna el indice el cual se encuentra el elemento --}}
            </h1>

            @if ($current->description)
                <p class="text-gray-600 mt-2">
                    {{ $current->description }}
                </p>
            @endif

            <div class="flex items-center space-x-2">
                <x-toggle /> Marcar esta unidad como vista
            </div>

            <div class="bg-white shadow-xl rounded-lg px-6 py-4 mt-2">
                <div class="flex justify-between">
                    <a href="" class="font-bold">
                        Tema anterior
                    </a>

                    <a href="" class="font-bold">
                        Siguiente tema
                    </a>
                </div>
            </div>
        </div>

        <aside class="col-span-1 mb-8">
            <div class="card">
                <h1 class="text-2xl text-center mb-4 leading-8">
                    <a class="hover:text-blue-600" href="{{ route('courses.show', $course) }}">
                        {{ $course->title }}
                    </a>
                </h1>

                {{-- Información del profesor --}}
                <div class="flex items-center">
                    <figure class="mr-4 shrink-0"> {{-- En el caso de que no haya espacio, no lo reduzcas más --}}
                        <img class="w-12 h-12 object-cover rounded-full"
                            src=" {{ $course->teacher->profile_photo_url }}">
                    </figure>

                    <div class="flex-1"> {{-- Queremos que ocupe el mayor espacio disponible --}}
                        <p>
                            {{ $course->teacher->name }}
                        </p>
                    </div>
                </div>

                {{-- Avance --}}
                <div class="mt-2">
                    <p class="text-gray-600 text-sm">
                        10% completado
                    </p>

                    <div class="relative pt-1">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                            <div style="width:10%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Secciones --}}
                <ul class="space-y-4 text-gray-600">
                    @foreach ($sections as $section)
                        <li>
                            <button class="text-left flex justify-between">
                                <span>
                                    {{ $section['name'] }}
                                </span>

                                <i class="mt-1 fas fa-angle-down"></i>
                            </button>

                            <ul class="space-y-1 mt-2">
                                @foreach ($section['lessons'] as $lesson)
                                    <li>
                                        <a href="" class="w-full flex">
                                            <i class="fa-solid fa-circle mt-1 mr-2"></i>

                                            <span>
                                                {{ $lessons->search($lesson['id']) + 1 }}. {{ $lesson['name'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
    </div>
    </aside>
</div>
</div>
