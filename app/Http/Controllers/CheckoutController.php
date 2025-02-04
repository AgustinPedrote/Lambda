<?php

namespace App\Http\Controllers;

use App\Models\Course;
use CodersFree\Shoppingcart\Facades\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function createPaypalOrder()
    {
        $access_token = $this->generateAccessToken();
        $url = config('services.paypal.url') . "/v2/checkout/orders";

        Cart::instance('shopping');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $access_token,
        ])->post(
            $url,
            [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    0 => [
                        'amount' => [
                            'currency_code' => 'EUR',
                            'value' => Cart::subtotal(),
                            'breakdown' => [ //Suma de todos los items
                                'item_total' => [
                                    'currency_code' => 'EUR',
                                    'value' => Cart::subtotal(),
                                ],
                                'discount' => [
                                    'currency_code' => 'EUR',
                                    'value' => 0,
                                ],
                            ],
                        ],
                        'items' => Cart::content()->map(function ($item) {
                            return [
                                'name' => $item->name,
                                'unit_amount' => [
                                    'currency_code' => 'EUR',
                                    'value' => $item->price,
                                ],
                                'quantity' => $item->qty,
                                'sku' => $item->id,
                            ];
                        })->values()->toArray()
                    ]
                ],
            ],
        )->json();

        return $response;
    }

    public function capturePaypalOrder(Request $request)
    {
        $orderId = $request->orderID;

        $access_token = $this->generateAccessToken();
        $url = config('services.paypal.url') . "/v2/checkout/orders/{$orderId}/capture";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $access_token,
        ])->post(
            $url,
            [
                'intent' => 'CAPTURE',
            ],
        )->json();

        if (!isset($response['status']) || $response['status'] !== 'COMPLETED') {
            throw new Exception('Error al capturar la orden de PayPal: ' . json_encode($response));
        }

        /* Matriculación de usuarios */
        Cart::instance('shopping');

        foreach (Cart::content() as $item) {
            $course = Course::find($item->id);
            $course->students()->attach(auth()->id());
        }

        /* Destruir el carrito */
        Cart::destroy();

        /* Actualizar la base de datos */
        Cart::store(auth()->id());
    }

    public function generateAccessToken()
    {
        $client_id = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');

        $auth = base64_encode($client_id . ':' . $secret);

        $url = config('services.paypal.url') . "/v1/oauth2/token";

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $auth,
        ])
            ->asForm()
            ->post($url, [
                'grant_type' => 'client_credentials'
            ])->json();

        return $response['access_token'];
    }
}
