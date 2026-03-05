<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ShopElite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-900 to-emerald-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-shopping-bag text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">ShopElite Admin</h1>
            <p class="text-gray-400 mt-1">Sign in to your admin panel</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/admin/login" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email', 'admin@shopify.com') }}" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                        <input type="password" name="password" value="admin123" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition" required>
                    </div>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-3 rounded-lg font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In to Admin Panel
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-xs text-gray-500 font-medium mb-3 uppercase tracking-wide">Test Credentials</p>
                <div class="space-y-2">
                    <div class="bg-gray-50 rounded-lg p-3 flex justify-between items-center">
                        <div><p class="text-xs font-medium text-gray-700">Super Admin</p><p class="text-xs text-gray-500">admin@shopify.com / admin123</p></div>
                        <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">Admin</span>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 flex justify-between items-center">
                        <div><p class="text-xs font-medium text-gray-700">Store Manager</p><p class="text-xs text-gray-500">manager@shopify.com / manager123</p></div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Manager</span>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 flex justify-between items-center">
                        <div><p class="text-xs font-medium text-gray-700">Inventory Manager</p><p class="text-xs text-gray-500">inventory@shopify.com / inventory123</p></div>
                        <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">Inventory</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-sm text-emerald-600 hover:underline">← Back to Store</a>
            </div>
        </div>
    </div>
</body>
</html>
