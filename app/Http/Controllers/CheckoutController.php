<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('catalog')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Create a Stripe Payment Intent
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::create([
            'amount'   => (int) round($total * 100), // Stripe uses cents
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return view('checkout', [
            'cartItems'           => $cartItems,
            'total'               => $total,
            'clientSecret'        => $paymentIntent->client_secret,
            'stripeKey'           => config('services.stripe.key'),
            'paymentIntentId'     => $paymentIntent->id,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_address'  => 'required|string|max:255',
            'shipping_city'     => 'required|string|max:255',
            'shipping_phone'    => 'required|string|max:20',
            'notes'             => 'nullable|string|max:500',
            'payment_intent_id' => 'required|string',
        ]);

        // Verify the payment succeeded with Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::retrieve($data['payment_intent_id']);

        if ($paymentIntent->status !== 'succeeded') {
            return back()->with('error', 'Payment was not successful. Please try again.');
        }

        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = DB::transaction(function () use ($data, $cartItems, $total, $paymentIntent) {
            $order = Order::create([
                'user_id'            => auth()->id(),
                'total_price'        => $total,
                'status'             => 'processing',
                'shipping_address'   => $data['shipping_address'],
                'shipping_city'      => $data['shipping_city'],
                'shipping_phone'     => $data['shipping_phone'],
                'notes'              => $data['notes'] ?? null,
                'payment_intent_id'  => $paymentIntent->id,
                'payment_status'     => 'paid',
            ]);

            foreach ($cartItems as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                if ($product->stock < $item->quantity) {
                    throw new \RuntimeException("Insufficient stock for '{$product->name}'. Only {$product->stock} left.");
                }

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
                $product->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', auth()->id())->delete();

            return $order;
        });

        return redirect()->route('checkout.success', $order)->with('success', 'Payment successful! Your order has been placed.');
    }

    public function success(Order $order)
    {
        // Make sure the order belongs to the logged-in user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('checkout-success', compact('order'));
    }
}
