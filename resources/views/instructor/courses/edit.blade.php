<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Curso: {{ $course->title }}
        </h2>
    </x-slot>

    <x-instructor.course-sidebar :course="$course">

        <form action="{{ route('instructor.courses.update', $course) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <p class="text-2xl font-semibold">
                Información del curso
            </p>

            <hr class="mt-2 mb-6">

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label value="Título del curso" class="mb-1" />

                <x-input type="text" class="w-full" value="{{ old('title', $course->title) }}" name="title" />
            </div>

            @empty($course->published_at)
                <div class="mb-4">
                    <x-label value="Slug del curso" class="mb-1" />

                    <x-input type="text" class="w-full" value="{{ old('slug', $course->slug) }}" name="slug" />
                </div>
            @endempty

            <div class="mb-4">
                <x-label value="Resumen" class="mb-1" />

                <x-textarea name="summary" class="w-full">{{ old('summary', $course->summary) }}</x-textarea>
            </div>

            <div class="mb-4 ckeditor">
                <x-label value="Descripción" class="mb-1" />

                <x-textarea id="editor" name="description"
                    class="w-full">{{ old('description', $course->description) }}</x-textarea>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div>
                    <x-label class="mb-1">
                        Categorías
                    </x-label>

                    <x-select class="w-full" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-label class="mb-1">
                        Niveles
                    </x-label>

                    <x-select class="w-full" name="level_id">
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" @selected(old('level_id', $course->level_id) == $level->id)>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-label class="mb-1">
                        Precios
                    </x-label>

                    <x-select class="w-full" name="price_id">
                        @foreach ($prices as $price)
                            <option value="{{ $price->id }}" @selected(old('price_id', $course->price_id) == $price->id)>
                                @if ($price->value == 0)
                                    Gratis
                                @else
                                    {{ number_format($price->value, 2) }} € (nivel {{ $loop->index }})
                                @endif
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div>
                <p class="text-2xl font-semibold mb-2">
                    Imagen del curso
                </p>

                <div class="grid md:grid-cols-2 gap-4">
                    <figure>
                        <img id="imgPreview" class="w-full aspect-video object-cover object-center"
                            src="{{ $course->image }}" alt=""> {{-- Accedo al accesor "image" --}}
                    </figure>

                    <div>
                        <p class="mb-2">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deserunt
                            mollitia fugiat! Vel error eum culpa mollitia, saepe ut aperiam, quidem
                            perferendis rerum iste impedit.
                        </p>

                        <label>
                            <span class="btn btn-blue md:hidden cursor-pointer">
                                Selecciona una imagen
                            </span>

                            <input class="hidden md:block" type="file" accept="image/*" name="image"
                                onchange="preview_image(event, '#imgPreview')">
                        </label>

                        <div class="flex md:justify-end mt-4">
                            <x-button>
                                Guardar cambios
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </x-instructor.course-sidebar>

    <!-- Incluir e inicializar el script de CKEditor 5 desde el CDN -->
    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush

</x-instructor-layout>
