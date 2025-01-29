<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        return view('courses.index');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function myCourses()
    {
        $courses = auth()->user()->courses_enrolled;

        return view('courses.my-courses', compact('courses'));
    }

    public function status(Course $course, Lesson $lesson = null)
    {
        /* Recuperar las lecciones en orden */
        $sections = Section::where('course_id', $course->id)
            ->whereHas('lessons', function ($query) {
                $query->where('is_published', true);
            })
            ->with('lessons', function ($query) {
                $query->where('is_published', true)
                    ->orderBy('position', 'asc');
            })
            ->orderBy('position', 'asc')
            ->get();

        $lessons = $sections->pluck('lessons')->collapse();

        /* Si no hay lección seleccionada se encuentra la primera lección */
        if (!$lesson) {
            $lesson = Lesson::whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->whereHas('users', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('current', true);
            })->first();

            /* Si no ha visualizado ninguna lección que se muestre la primera */
            if (!$lesson) {
                $lesson = $lessons->first();
            }

            return redirect()->route('courses.status', [$course, $lesson]);
        }

        /* Se lleva control de la lección visualizada */
        if (auth()->check()) {
            DB::table('course_lesson_user')
                ->where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->update([
                    'current' => false
                ]);

            DB::table('course_lesson_user')
                ->updateOrInsert(
                    /* Si encuentra algun registro con estas caracteristicas  */
                    [
                        'course_id' => $course->id,
                        'lesson_id' => $lesson->id,
                        'user_id' => auth()->id(),
                    ],
                    /* Lo actualiza con este registro */
                    [
                        'current' => true,
                    ]
                );
        }

        return view('courses.status', compact('course', 'sections', 'lessons', 'lesson'));
    }
}
