<div>
    <h1 class="text-2xl font-semibold">
        Video promocional
    </h1>

    <hr class="mt-2 mb-6">

    <div class="grid grid-cols-2 gap-6">
        <div class="col-span-1">
            @if ($course->video_path)
                <video controls class="aspect-video">
                    <source src="{{ Storage::url($course->video_path) }}">
                </video>
            @else
                <figure>
                    <img class="w-full aspect-video object-cover" src="{{ $course->image }}" alt="{{ $course->title }}">
                </figure>
            @endif
        </div>
        <div class="col-span-1">
            {{-- <form wire:submit="save">
                <p class="mb-4">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime quas commodi iusto assumenda labore
                    obcaecati, soluta molestias velit dolore ducimus, dicta placeat ratione rem a et minima? Nisi,
                    necessitatibus dicta.
                </p>

                <x-progress-indicators wire:model="video" />

                <div class="flex justify-end mt-4">
                    <x-button>
                        Subir video
                    </x-button>
                </div>

                <x-validation-errors />
            </form> --}}

            <form action="{{ route('instructor.courses.uploadVideo', $course) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <p class="mb-4">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime quas commodi iusto assumenda labore
                    obcaecati, soluta molestias velit dolore ducimus, dicta placeat ratione rem a et minima? Nisi,
                    necessitatibus dicta.
                </p>

                <input type="file" name="video" id="video" class="mt-1 block w-full" accept="video/*" required>

                <div class="flex justify-end mt-4">
                    <x-button>
                        Subir video
                    </x-button>
                </div>

                <x-validation-errors />
            </form>
        </div>
    </div>
</div>
