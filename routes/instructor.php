<?php

use App\Http\Controllers\Instructor\CourseController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('instructor.dashboard');
}); */

# Ruta de paso
Route::redirect('/', '/instructor/courses')
    ->name('home');

/* Cursos */
Route::resource('courses', CourseController::class);

/* Videos */
Route::get('courses/{course}/video', [CourseController::class, 'video'])
    ->name('courses.video');

/* Subida de video promocional */
Route::post('courses/{course}/upload-video', [CourseController::class, 'uploadVideo'])
    ->name('courses.uploadVideo');

/* Goals */
Route::get('courses/{course}/goals', [CourseController::class, 'goals'])
    ->name('courses.goals');

