<x-app-layout>

    <x-container class="mt-8">
        @livewire('course-status', [
            'course' => $course,
            'sections' => $sections->toArray(),
            'lessons' => $lessons,
            'current' => $lesson,
        ])
    </x-container>

</x-app-layout>
