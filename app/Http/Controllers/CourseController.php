<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
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
        /* Si no tenemos una lección va a buscar la primera del curso en el orden que la hayamos dejado*/
        if (!$lesson) {
            $lesson = Lesson::whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->whereHas('users', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('current', true);
            })->first();

            /* Si no ha visualizado ninguna lección que se muestre la primera */
            if (!$lesson) {
                $course->load(['sections' => function ($query) {
                    $query->orderBy('position', 'asc')
                        ->with('lessons', function ($query) {
                            $query->orderBy('position', 'asc')
                                ->where('is_published', true);
                        });
                }]);

                $lesson = $course->sections->pluck('lessons')->collapse()->first();
            }

            return redirect()->route('courses.status', [$course, $lesson]);
        }

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

        return view('courses.status', compact('course', 'lesson'));
    }
}
