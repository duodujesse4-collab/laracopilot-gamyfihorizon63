<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ShopElite')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">
        <div class="p-5 border-b border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <div class="font-bold text-lg">ShopElite</div>
                    <div class="text-xs text-emerald-400">Admin Panel</div>
                </div>
            </div>
        </div>

        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-sm"></i>
                </div>
                <div>
                    <div class="font-medium text-sm">{{ session('admin_user', 'Admin') }}</div>
                    <div class="text-xs text-gray-400">{{ session('admin_role', 'Admin') }}</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-tachometer-alt w-5"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-emerald-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-box w-5"></i> Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-tags w-5"></i> Categories
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-shopping-cart w-5"></i> Orders
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-emerald-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-users w-5"></i> Customers
            </a>
            <div class="pt-4 mt-4 border-t border-gray-700">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition" target="_blank">
                    <i class="fas fa-store w-5"></i> View Store
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-red-700 transition text-left">
                        <i class="fas fa-sign-out-alt w-5"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between flex-shrink-0">
            <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ date('l, F j, Y') }}</span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
