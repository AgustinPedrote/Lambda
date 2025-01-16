<?php

namespace App\Livewire;

use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CourseEnrolled extends Component
{
    public $course;

    public function addCart()
    {
        /* Para trabajar mas instancias aparte de 'default */
        Cart::instance('shopping');
        Cart::add([
            'id' => $this->course->id,
            'name' => $this->course->title,
            'qty' => 1,
            'price' => $this->course->price->value,
            /* Para mas valores en 'options' */
            'options' => [
                'slug' => $this->course->slug,
                'image' => $this->course->image,
                'teacher' => $this->course->teacher->name
            ]
        ]);

        /* Alberga los productos del carrito en la tabla */
        if (auth()->check()) {
            Cart::store(auth()->id()); //Identificador
        }

        /* Actualiza icono carrito */
        $this->dispatch('cart-updated', Cart::count());
    }

    public function removeCart()
    {
        Cart::instance('shopping');
        $itemCart = Cart::content()->where('id', $this->course->id)->first();

        if ($itemCart) {
            Cart::remove($itemCart->rowId);
        }

        /* Alberga los productos del carrito en la tabla */
        if (auth()->check()) {
            Cart::store(auth()->id()); //Identificador
        }

        /* Actualiza icono carrito */
        $this->dispatch('cart-updated', Cart::count());
    }

    public function buyNow()
    {
        /* Primero elimino los artículos del carrito */
        $this->removeCart();

        /* Agrego el artículo al carrito */
        $this->addCart();

        /* Redireccionar a la página del checkout */
        return redirect()->route('cart.index');
    }

    public function enrolled()
    {
        if (auth()->check()) {
            $this->course->students()->attach(auth()->id());
        }

        return redirect()->route('courses.status', $this->course);
    }

    public function render()
    {
        return view('livewire.course-enrolled');
    }
}
