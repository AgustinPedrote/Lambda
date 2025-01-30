<x-app-layout>

    <x-container class="mt-8">
        @livewire('course-status', [
            'course' => $course,
            'sections' => $sections->toArray(),
            'lessons' => $lessons->pluck('id'),
            'current' => $lesson,
        ])
    </x-container>

</x-app-layout>
