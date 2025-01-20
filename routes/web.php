<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseController; //Hay dos 'CourseController, ten ojo.
use App\Http\Controllers\WelcomeController;
use App\Models\Course;
use App\Models\Lesson;
use CodersFree\Shoppingcart\Facades\Cart;
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

Route::get('courses-status/{course}', [CourseController::class, 'status'])
    ->name('courses.status');

Route::get('cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::get('checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('checkout/createPaypalOrder', [CheckoutController::class, 'createPaypalOrder'])
->name('checkout.createPaypalOrder');

/* Función para pruebas */
Route::get('prueba', function () {
    //
});
