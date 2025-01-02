<x-app-layout>

    {{-- Portada --}}
    <figure class="mb-20">
        <img class="w-full aspect-[3/1] object-cover object-center" src="{{ asset('img/welcome/portada.jpg') }}"
            alt="">
    </figure>

    {{-- Contenido --}}
    <section class="mb-24">
        <h1 class="text-2xl font-semibold text-center mb-8">
            CONTENIDO
        </h1>

        <ul class="grid grid-cols-4 gap-6 mx-6">
            {{-- Cursos online --}}
            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg"
                        src="https://cdn.pixabay.com/photo/2019/05/16/20/15/online-4208112_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Cursos online
                    </a>
                </h1>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem modi quia deserunt neque. Beatae ab et
                    sunt libero quas laudantium non quis doloribus culpa?
                </p>
            </li>

            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg"
                        src="https://cdn.pixabay.com/photo/2015/07/17/22/43/student-849822_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Diseño web
                    </a>
                </h1>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati quidem expedita modi molestias
                    asperiores vero eveniet et at, rerum ratione ad.
                </p>
            </li>

            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg"
                        src="https://cdn.pixabay.com/photo/2020/07/08/04/12/work-5382501_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Asesorías
                    </a>
                </h1>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem modi quia deserunt neque. Beatae ab et
                    sunt libero.
                </p>
            </li>

            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg"
                        src="https://cdn.pixabay.com/photo/2015/03/22/15/26/blog-684748_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Blog
                    </a>
                </h1>

                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique vel, nam mollitia molestiae
                    dolorem accusamus necessitatibus eligendi cum.
                </p>
            </li>
        </ul>
    </section>

    {{-- Cursos --}}
    <section>
        <x-container>
            <h1 class="text-2xl font-semibold text-center mb-8">
                ÚLTIMOS CURSOS
            </h1>

            <ul class="grid grid-cols-4 gap-6">
                @foreach ($courses as $course)
                    <li>
                        <div class="bg-white rounded-lg overflow-hidden">
                            <figure>
                                <img class="w-full aspect-video object-cover object-center" src="{{ $course->image }}"
                                    alt="{{ $course->title }}">
                            </figure>

                            <div class="px-6 pt-4 pb-5">
                                <h1 class="line-clamp-2 text-lg leading-5 min-h-[42px] mb-1"> {{-- Como máximo tenga dos líneas --}}
                                    <a href="">
                                        {{ $course->title }}
                                    </a>
                                </h1>

                                <p class="text-gray-500 text-sm mb-1">
                                    Prof: {{ $course->teacher->name }}
                                </p>

                                <ul class="text-xs flex space-x-1 mb-1">
                                    <li>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                    </li>
                                </ul>

                                <p class="font-semibold mb-2">
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

                                <a href="" class="btn btn-blue block w-full text-center">
                                    Más información
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </x-container>
    </section>

</x-app-layout>
