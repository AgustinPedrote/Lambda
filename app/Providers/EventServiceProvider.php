<?php

namespace App\Providers;

use App\Events\VideoUploaded;
use App\Listeners\VideoUploaded\ProcessLessonVideo;
use App\Listeners\Login\RestoreShoppingCart; // Importa el listener
use Illuminate\Auth\Events\Login; // Importa el evento Login
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

/* Laravel utiliza el EventServiceProvider para enlazar eventos y oyentes */

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Evento para videos subidos
        VideoUploaded::class => [
            ProcessLessonVideo::class,
        ],

        // Evento de inicio de sesión
        Login::class => [
            RestoreShoppingCart::class, // Listener para restaurar el carrito
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
