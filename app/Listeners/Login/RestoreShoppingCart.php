<?php

namespace App\Listeners\Login;

use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RestoreShoppingCart
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
    public function handle(Login $event): void
    {
        Cart::instance('shopping')->restore($event->user->id);

        /* Cart::instance('shopping');
        Cart::restore($event->user->id); */
    }
}
