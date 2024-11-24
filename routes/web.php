<?php

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

/* Prueba FFMpeg para la duración y la imagen del video */
Route::get('prueba', function () {
    $lesson = Lesson::find(19);

    if ($lesson->platform == 1) {
        $media = FFMpeg::open($lesson->video_path);

        $lesson->duration = $media->getDurationInSeconds(); /* Rellena el campo 'duration' con la duración del video */
        $lesson->image_path = "courses/lessons/posters/{$lesson->slug}.jpg";

        $media->getFrameFromSeconds(10)
            ->export()
            ->save($lesson->image_path);

        $lesson->is_processed = true;

        $lesson->save();
    } else {
        /* Expresión regular para recuperar el ID de la URL de youtube */
        $patron = '%^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=))([\w-]{10,12})%';

        /* Función PHP para recuperar el ID */
        preg_match($patron, $lesson->video_original_name, $matches);

        $lesson->video_path = $matches[1];

        /* Se necesita recuperar la información del video a través de una consulta a la URL y crear API key de youtube */
        $video_info = Http::get('https://www.googleapis.com/youtube/v3/videos?id=' . $lesson->video_path . '&key=' . config('services.youtube.key') . '&part=snippet,contentDetails,statistics,status')->json();

        $duration = $video_info['items'][0]['contentDetails']['duration'];
        $patron = "%^PT(\d+H)?(\d+M)?(\d+S)?$%";
        preg_match($patron, $duration, $matches);

        /* Coger de la cadena los numeros y dejar fuera el decimal que simboliza las horas/minutos/segundos */
        $horas = isset($matches[1]) ? (int)substr($matches[1], 0, -1) : 0;
        $minutos = isset($matches[2]) ? (int)substr($matches[2], 0, -1) : 0;
        $segundos = isset($matches[3]) ? (int)substr($matches[3], 0, -1) : 0;

        /* Se pasa el tiempo a segundos que es la medida de tiempo quie se utiliza en duración */
        $lesson->duration = ($horas * 3600) + ($minutos * 60) + $segundos;

        /* Recuperar la portada */
        $lesson->image_path = 'https://img.youtube.com/vi/' . $lesson->video_path . '/0.jpg';

        $lesson->is_processed = true;
        $lesson->save();
    }

    return "Procesado";
});
