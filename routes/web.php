<?php

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

Route::get('/', function () {
    return view('welcome');
});

/* Función para pruebas */
Route::get('prueba', function () {
    $course = Course::first();

    $sections = $course->sections()
        ->with(['lessons' => function ($query) { /* Función callback */
            $query->orderBy('position', 'asc');
        }])
        ->get();

    /* Muestra solo la información de lessons */
    $orderLessons = $sections->pluck('lessons')
        ->collapse() /* Combinar las lecciones de todos los arrays en uno */
        ->pluck('id');

    return $orderLessons->search(30) + 1;
});

/* Min 9 */
