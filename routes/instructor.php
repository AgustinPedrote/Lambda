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
