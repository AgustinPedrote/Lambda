<?php

namespace App\Livewire;

use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ManageShoppingCart extends Component
{
    public function remove($rowId)
    {
        Cart::instance('shopping')->remove($rowId);
        /* Cart::remove($rowId); */

        /* Actualizar */
        $this->dispatch('cart-updated', Cart::content());

        /* Alberga los productos del carrito en la tabla */
        if (auth()->check()) {
            Cart::store(auth()->id()); //Identificador
        }
    }

    public function destroy()
    {
        Cart::instance('shopping');
        Cart::destroy();

        /* Actualizar */
        $this->dispatch('cart-updated', Cart::content());

        /* Alberga los productos del carrito en la tabla */
        if (auth()->check()) {
            Cart::store(auth()->id()); //Identificador
        }
    }

    public function render()
    {
        return view('livewire.manage-shopping-cart');
    }
}
