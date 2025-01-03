<?php

use App\Http\Controllers\CourseController; //Hay dos 'CourseController, ten ojo.
use App\Http\Controllers\WelcomeController;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('courses/{course}', [CourseController::class, 'show'])
    ->name('courses.show');

/* Función para pruebas */
Route::get('prueba', function () {
    //
});
