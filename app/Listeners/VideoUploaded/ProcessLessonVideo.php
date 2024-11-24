<?php

namespace App\Listeners\VideoUploaded;

use App\Events\VideoUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

/* Oyente */

class ProcessLessonVideo implements ShouldQueue /* Poner trabajos en cola con 'ShouldQueue */
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VideoUploaded $event): void
    {
        $lesson = $event->lesson;

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
    }
}
