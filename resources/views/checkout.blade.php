@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-white min-h-screen pt-12 pb-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-semibold text-slate-900 tracking-tight mb-10 border-b border-slate-100 pb-6">Checkout</h1>

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form id="payment-form" method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <input type="hidden" name="payment_intent_id" id="payment_intent_id" value="{{ $paymentIntentId }}">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

                {{-- LEFT: Shipping + Payment --}}
                <div class="lg:col-span-3 space-y-8">

                    {{-- Shipping Information --}}
                    <div>
                        <h2 class="text-base font-semibold text-slate-900 mb-5">Shipping Information</h2>

                        @if($errors->any())
                            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg mb-4 text-sm">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-slate-600 mb-1.5">Street Address</label>
                                <input type="text" name="shipping_address"
                                    value="{{ old('shipping_address', auth()->user()->address) }}"
                                    required
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-0 focus:border-rose-400 text-sm transition-colors text-slate-800">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1.5">City</label>
                                    <input type="text" name="shipping_city"
                                        value="{{ old('shipping_city') }}"
                                        required
                                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-0 focus:border-rose-400 text-sm transition-colors text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1.5">Phone Number</label>
                                    <input type="text" name="shipping_phone"
                                        value="{{ old('shipping_phone', auth()->user()->phone) }}"
                                        required
                                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-0 focus:border-rose-400 text-sm transition-colors text-slate-800">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-slate-600 mb-1.5">Order Notes <span class="text-slate-400">(optional)</span></label>
                                <textarea name="notes" rows="2"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-0 focus:border-rose-400 text-sm transition-colors text-slate-800">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div>
                        <h2 class="text-base font-semibold text-slate-900 mb-5">Payment</h2>
                        <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                            <div id="payment-element">
                                {{-- Stripe Elements mounts here --}}
                            </div>
                            <div id="payment-message" class="hidden text-sm text-rose-600 mt-3"></div>
                        </div>
                        <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Your payment info is secured by Stripe. We never store your card details.
                        </p>
                    </div>
                </div>

                {{-- RIGHT: Order Summary --}}
                <div class="lg:col-span-2">
                    <div class="sticky top-28">
                        <h2 class="text-base font-semibold text-slate-900 mb-5">Order Summary</h2>
                        <div class="border border-slate-100 rounded-xl overflow-hidden">
                            <div class="divide-y divide-slate-100">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center gap-4 p-4">
                                        <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-50 flex-shrink-0">
                                            @if($item->product->image)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-slate-900 truncate">{{ $item->product->name }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <span class="text-sm font-medium text-slate-900">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="bg-slate-50 p-4 space-y-2 border-t border-slate-100">
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Subtotal</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Shipping</span>
                                    <span class="text-green-600 font-medium">Free</span>
                                </div>
                                <div class="flex justify-between text-base font-semibold text-slate-900 border-t border-slate-200 pt-2 mt-2">
                                    <span>Total</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <button id="submit-btn" type="submit"
                            class="mt-6 w-full bg-rose-500 hover:bg-rose-600 text-white py-3.5 rounded-full font-medium text-sm transition-colors flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span id="btn-text">Pay ${{ number_format($total, 2) }}</span>
                            <svg id="spinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </button>

                        <p class="text-center text-xs text-slate-400 mt-3">
                            Test card: <span class="font-mono bg-slate-100 px-1 rounded">4242 4242 4242 4242</span> · Any future date · Any CVC
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const clientSecret = '{{ $clientSecret }}';

    const appearance = {
        theme: 'stripe',
        variables: {
            colorPrimary: '#f43f5e',
            colorBackground: '#ffffff',
            colorText: '#1e293b',
            borderRadius: '8px',
            fontFamily: 'Inter, sans-serif',
        },
    };

    const elements = stripe.elements({ appearance, clientSecret });
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const spinner = document.getElementById('spinner');
    const messageEl = document.getElementById('payment-message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        btnText.textContent = 'Processing...';
        spinner.classList.remove('hidden');
        messageEl.classList.add('hidden');

        // Confirm the payment with Stripe
        const { error, paymentIntent } = await stripe.confirmPayment({
            elements,
            confirmParams: { return_url: window.location.href }, // fallback
            redirect: 'if_required',
        });

        if (error) {
            messageEl.textContent = error.message;
            messageEl.classList.remove('hidden');
            submitBtn.disabled = false;
            btnText.textContent = 'Pay ${{ number_format($total, 2) }}';
            spinner.classList.add('hidden');
            return;
        }

        if (paymentIntent && paymentIntent.status === 'succeeded') {
            // Payment succeeded — submit the form to Laravel to record the order
            document.getElementById('payment_intent_id').value = paymentIntent.id;
            form.submit();
        } else {
            messageEl.textContent = 'Payment could not be completed. Please try again.';
            messageEl.classList.remove('hidden');
            submitBtn.disabled = false;
            btnText.textContent = 'Pay ${{ number_format($total, 2) }}';
            spinner.classList.add('hidden');
        }
    });
</script>
@endsection
