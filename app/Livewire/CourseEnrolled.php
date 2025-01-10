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
    }

    public function removeCart()
    {
        Cart::instance('shopping');
        $itemCart = Cart::content()->where('id', $this->course->id)->first();

        if ($itemCart) {
            Cart::remove($itemCart->rowId);
        }
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

    public function render()
    {
        return view('livewire.course-enrolled');
    }
}
