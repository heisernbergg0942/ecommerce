<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Angkor Shop') - Minimal E-Commerce</title>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full bg-white flex flex-col text-slate-800 antialiased selection:bg-rose-100 selection:text-rose-900">
    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <span class="text-2xl font-semibold tracking-tight text-slate-900 transition-colors">Angkor<span class="text-rose-500">Shop</span>.</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-900 font-medium transition-colors duration-200">Home</a>
                    <a href="{{ route('catalog') }}" class="text-slate-500 hover:text-slate-900 font-medium transition-colors duration-200">Catalog</a>
                    <a href="{{ route('cart') }}" class="text-slate-500 hover:text-rose-500 font-medium transition-colors duration-200 flex items-center space-x-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        <span>Cart</span>
                    </a>
                </div>

                {{-- Auth Links --}}
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-slate-600 hover:text-slate-900 transition-colors font-medium">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-lg shadow-lg py-2 hidden group-hover:block opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ route('account') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-rose-500 transition-colors">My Account</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-rose-500 transition-colors">Admin Panel</a>
                                @endif
                                <div class="h-px bg-slate-50 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-600 hover:text-rose-500 transition-colors">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-slate-900 hover:bg-rose-500 rounded-full transition-all duration-300">Register</a>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">Home</a>
                <a href="{{ route('catalog') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">Catalog</a>
                <a href="{{ route('cart') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">Cart</a>
                <div class="h-px bg-slate-50 my-2"></div>
                @auth
                    <a href="{{ route('account') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">My Account</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">Admin Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-rose-500">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg text-sm font-medium flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-rose-50 text-rose-700 px-4 py-3 rounded-lg text-sm font-medium flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-100 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="inline-block">
                        <span class="text-xl font-semibold tracking-tight text-slate-900">Angkor<span class="text-rose-500">Shop</span>.</span>
                    </a>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-xs">Curated essentials for your minimal lifestyle. Simple, elegant, and timeless.</p>
                </div>
                
                <div>
                    <h3 class="text-slate-900 font-medium mb-4">Shop</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('catalog') }}" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">All Products</a></li>
                        <li><a href="{{ route('catalog', ['category' => 'engine-parts']) }}" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">Engine Parts</a></li>
                        <li><a href="{{ route('catalog', ['category' => 'exterior-accessories']) }}" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">Exterior</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-slate-900 font-medium mb-4">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">FAQ</a></li>
                        <li><a href="#" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">Shipping</a></li>
                        <li><a href="#" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">Returns</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-slate-900 font-medium mb-4">Contact</h3>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li>Phnom Penh, Cambodia</li>
                        <li>+855 12 345 678</li>
                        <li>hello@angkorshop.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-400">&copy; {{ date('Y') }} AngkorShop. Minimal design.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
