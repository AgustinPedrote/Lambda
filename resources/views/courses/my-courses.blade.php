<x-app-layout>
    <x-container width="5xl" class="mt-12">

        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($courses as $course)
                <li>
                    <a href="{{ route('courses.status', $course) }}" class="block">
                        <figure>
                            <img class="aspect-video w-full rounded-lg object-cover object-center"
                                src="{{ $course->image }}" alt="">
                        </figure>

                        <p class="truncate mt-1">
                            {{ $course->title }}
                        </p>
                    </a>
                </li>
            @empty
                <li class="grid col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4">
                    <div class="card">
                        <figure>
                            <img class="w-64 mx-auto"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKDAU_khPHygXtfrxHeT2sTirHM4z9MuG0ZQ&s"
                                alt="">
                        </figure>

                        <p class="my-2 text-center">
                            Parece que aún no tienes cursos matriculados.
                        </p>

                        <div class="flex justify-center">
                            <a href="{{ route('courses.index') }}" class="btn btn-blue">
                                Comprar un curso
                            </a>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>

    </x-container>
</x-app-layout>
