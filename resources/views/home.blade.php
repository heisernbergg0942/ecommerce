@extends('layouts.app')

@section('title', 'Home')

@section('content')
{{-- Hero Section --}}
<section class="bg-white text-slate-900 py-24 md:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-slate-900 mb-6">
                Curated essentials for your minimal lifestyle.
            </h1>
            <p class="text-xl text-slate-500 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                Discover high-quality, beautifully designed products. Everything you need, and nothing you don't.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('catalog') }}" class="inline-flex justify-center items-center px-8 py-3.5 text-sm font-medium text-white bg-rose-500 rounded-full hover:bg-rose-600 transition-colors">
                    Shop Collection
                </a>
                <a href="{{ route('catalog', ['category' => 'engine-parts']) }}" class="inline-flex justify-center items-center px-8 py-3.5 text-sm font-medium text-slate-700 bg-slate-50 rounded-full hover:bg-slate-100 transition-colors">
                    View Categories
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Features Bar --}}
<section class="bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-200">
            <div class="py-4 md:py-0">
                <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-1">Free Shipping</h3>
                <p class="text-sm text-slate-500">On orders over $150</p>
            </div>
            <div class="py-4 md:py-0">
                <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-1">Easy Returns</h3>
                <p class="text-sm text-slate-500">30-day return policy</p>
            </div>
            <div class="py-4 md:py-0">
                <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-1">Secure Checkout</h3>
                <p class="text-sm text-slate-500">100% safe & secure</p>
            </div>
        </div>
    </div>
</section>

{{-- Categories Section --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-12 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-semibold text-slate-900 tracking-tight">Categories</h2>
            <a href="{{ route('catalog') }}" class="text-sm font-medium text-rose-500 hover:text-rose-600 transition-colors">View All &rarr;</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('catalog', ['category' => $category->slug]) }}" class="group block text-center">
                    <div class="aspect-square bg-slate-50 rounded-full mb-4 overflow-hidden relative flex items-center justify-center transition-transform duration-300 group-hover:-translate-y-1 group-hover:shadow-sm">
                        @if($category->image)
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out opacity-80 group-hover:opacity-100">
                        @else
                            <span class="text-slate-300">Image</span>
                        @endif
                    </div>
                    <h3 class="font-medium text-slate-900 group-hover:text-rose-500 transition-colors text-sm">{{ $category->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-12 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-semibold text-slate-900 tracking-tight">Featured</h2>
            <a href="{{ route('catalog') }}" class="text-sm font-medium text-rose-500 hover:text-rose-600 transition-colors">Shop All &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                <div class="group flex flex-col">
                    <a href="{{ route('product.show', $product->slug) }}" class="relative aspect-[4/5] overflow-hidden bg-slate-50 mb-4 rounded-lg block">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                        @else
                            <div class="flex items-center justify-center h-full text-slate-300 text-sm">No Image</div>
                        @endif
                        
                        @if($product->stock > 0 && $product->stock < 10)
                            <div class="absolute top-3 left-3">
                                <span class="bg-rose-100 text-rose-700 text-xs font-medium px-2.5 py-1 rounded-sm">Low Stock</span>
                            </div>
                        @endif
                    </a>
                    
                    <div class="flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-1">
                            <a href="{{ route('product.show', $product->slug) }}" class="block">
                                <h3 class="font-medium text-slate-900 group-hover:text-rose-500 transition-colors text-base line-clamp-1">{{ $product->name }}</h3>
                            </a>
                            <span class="font-medium text-slate-900 ml-2">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <span class="text-sm text-slate-500">{{ $product->category->name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Minimal CTA --}}
<section class="py-24 bg-rose-50 text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-rose-900 mb-6 tracking-tight">Join the newsletter</h2>
        <p class="text-rose-700 mb-8 max-w-md mx-auto">Subscribe to receive updates, access to exclusive deals, and more.</p>
        <form class="flex max-w-md mx-auto gap-2">
            <input type="email" placeholder="Enter your email" class="flex-grow px-4 py-3 bg-white border border-rose-200 rounded-full focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent text-sm">
            <button type="button" class="px-6 py-3 bg-rose-500 text-white rounded-full text-sm font-medium hover:bg-rose-600 transition-colors">Subscribe</button>
        </form>
    </div>
</section>
@endsection
