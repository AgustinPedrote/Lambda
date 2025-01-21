<?php

namespace App\Http\Middleware;

use Closure;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCartItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Cart::instance('shopping');

        if (Cart::count() === 0) {
            return redirect()->route('cart.index');
        }

        return $next($request);
    }
}
