<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ShopElite - Premium Online Store')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .cart-badge { animation: pulse 2s infinite; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Bar -->
    <div class="bg-emerald-700 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <span>🚚 Free shipping on orders over $100!</span>
            <div class="flex gap-4">
                @if(session('user_logged_in'))
                    <span>Hello, {{ session('user_name') }}!</span>
                    <a href="{{ route('account') }}" class="hover:underline">My Account</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endif
                <a href="{{ route('admin.login') }}" class="hover:underline">Admin Panel</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Shop<span class="text-emerald-600">Elite</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-emerald-600 font-medium transition">Home</a>
                    <a href="{{ route('shop') }}" class="text-gray-600 hover:text-emerald-600 font-medium transition">Shop</a>
                    <div class="relative group">
                        <button class="text-gray-600 hover:text-emerald-600 font-medium transition flex items-center gap-1">Categories <i class="fas fa-chevron-down text-xs"></i></button>
                        <div class="absolute top-full left-0 bg-white shadow-xl rounded-lg py-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            @php $navCats = App\Models\Category::take(8)->get(); @endphp
                            @foreach($navCats as $cat)
                                <a href="{{ route('shop.category', $cat->slug) }}" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('shop') }}?featured=1" class="text-gray-600 hover:text-emerald-600 font-medium transition">Deals</a>
                </div>

                <div class="flex items-center gap-4">
                    <form action="{{ route('shop') }}" method="GET" class="hidden md:flex">
                        <div class="flex">
                            <input type="text" name="search" placeholder="Search products..." class="border border-gray-300 rounded-l-lg px-4 py-2 text-sm focus:outline-none focus:border-emerald-500 w-48">
                            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-r-lg hover:bg-emerald-700"><i class="fas fa-search text-sm"></i></button>
                        </div>
                    </form>

                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-emerald-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @php $cartCount = count(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @if(session('user_logged_in'))
                        <a href="{{ route('account') }}" class="hidden md:flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-2 rounded-lg hover:bg-emerald-100 transition">
                            <i class="fas fa-user-circle"></i>
                            <span class="text-sm font-medium">Account</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                            <i class="fas fa-sign-in-alt text-sm"></i>
                            <span class="text-sm font-medium">Login</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2 fade-in">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2 fade-in">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-bold">ShopElite</span>
                </div>
                <p class="text-gray-400 text-sm">Your premium destination for quality products. Shop with confidence and enjoy fast, reliable delivery.</p>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-emerald-600 transition"><i class="fab fa-facebook-f text-xs"></i></a>
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-emerald-600 transition"><i class="fab fa-twitter text-xs"></i></a>
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-emerald-600 transition"><i class="fab fa-instagram text-xs"></i></a>
                </div>
            </div>
            <div>
                <h4 class="font-semibold mb-4 text-gray-200">Shop</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('shop') }}" class="hover:text-emerald-400 transition">All Products</a></li>
                    <li><a href="{{ route('shop') }}?sort=popular" class="hover:text-emerald-400 transition">Best Sellers</a></li>
                    <li><a href="{{ route('shop') }}?sort=newest" class="hover:text-emerald-400 transition">New Arrivals</a></li>
                    <li><a href="{{ route('shop') }}" class="hover:text-emerald-400 transition">Deals & Offers</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4 text-gray-200">Account</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('account') }}" class="hover:text-emerald-400 transition">My Account</a></li>
                    <li><a href="{{ route('account.orders') }}" class="hover:text-emerald-400 transition">My Orders</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-emerald-400 transition">Shopping Cart</a></li>
                    <li><a href="{{ route('account.profile') }}" class="hover:text-emerald-400 transition">Profile Settings</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4 text-gray-200">Support</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li class="flex items-center gap-2"><i class="fas fa-envelope text-emerald-500"></i> support@shopelite.com</li>
                    <li class="flex items-center gap-2"><i class="fas fa-phone text-emerald-500"></i> 1-800-SHOP-ELITE</li>
                    <li class="flex items-center gap-2"><i class="fas fa-clock text-emerald-500"></i> Mon-Fri 9AM-6PM EST</li>
                </ul>
                <div class="mt-4 flex gap-2">
                    <img src="https://img.shields.io/badge/Visa-1A1F71?style=for-the-badge&logo=visa&logoColor=white" alt="Visa" class="h-6">
                    <img src="https://img.shields.io/badge/PayPal-00457C?style=for-the-badge&logo=paypal&logoColor=white" alt="PayPal" class="h-6">
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 py-6 text-center text-sm text-gray-500">
            <p>© {{ date('Y') }} ShopElite. All rights reserved.</p>
            <p class="mt-1">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="text-emerald-400 hover:underline">LaraCopilot</a></p>
        </div>
    </footer>
</body>
</html>
