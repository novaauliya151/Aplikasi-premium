<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'APK Premium - Aplikasi Premium Terbaik' }}</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
        .btn-primary {
            @apply bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105;
        }
        .card-hover {
            @apply transition-all duration-300 hover:shadow-2xl hover:-translate-y-2;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2 group">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-rocket text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">APK Premium</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-green-600 transition-colors font-medium flex items-center space-x-1">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="/product" class="text-gray-700 hover:text-green-600 transition-colors font-medium flex items-center space-x-1">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                    
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Hi, <strong>{{ Auth::user()->name }}</strong></span>
                            
                            @if(Auth::user()->isAdmin())
                                <a href="/admin/dashboard" class="text-purple-600 hover:text-purple-700 transition-colors font-medium flex items-center space-x-1">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Admin</span>
                                </a>
                            @else
                                <a href="/buyer/dashboard" class="text-blue-600 hover:text-blue-700 transition-colors font-medium flex items-center space-x-1">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                            @endif
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-700 transition-colors font-medium flex items-center space-x-1">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 transition-colors font-medium flex items-center space-x-1">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all font-semibold shadow-md">
                            <i class="fas fa-user-plus mr-1"></i>Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-gray-700 hover:text-green-600 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 pt-2 space-y-2">
                <a href="/" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded transition-colors">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="/product" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded transition-colors">
                    <i class="fas fa-box mr-2"></i>Produk
                </a>
                @auth
                    <div class="px-4 py-2 text-sm text-gray-600 border-t">
                        Hi, <strong>{{ Auth::user()->name }}</strong>
                    </div>
                    
                    @if(Auth::user()->isAdmin())
                        <a href="/admin/dashboard" class="block px-4 py-2 text-purple-600 hover:bg-purple-50 rounded transition-colors">
                            <i class="fas fa-user-shield mr-2"></i>Admin Dashboard
                        </a>
                    @else
                        <a href="/buyer/dashboard" class="block px-4 py-2 text-blue-600 hover:bg-blue-50 rounded transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white hover:from-green-600 hover:to-emerald-700 rounded transition-colors font-semibold text-center">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow flex items-center" role="alert">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow flex items-center" role="alert">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow flex items-center" role="alert">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg shadow flex items-center" role="alert">
                <i class="fas fa-info-circle mr-3 text-xl"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white shadow-lg mt-auto border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">APK Premium</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Platform terpercaya untuk membeli aplikasi premium dengan harga terjangkau dan kualitas terbaik.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="text-gray-600 hover:text-green-600 transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Home</a></li>
                        <li><a href="/product" class="text-gray-600 hover:text-green-600 transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Produk</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-envelope mr-2 text-green-600"></i>info@apkpremium.com</li>
                        <li class="flex items-center"><i class="fas fa-phone mr-2 text-green-600"></i>+62 812-3456-7890</li>
                        <li class="flex items-center"><i class="fas fa-map-marker-alt mr-2 text-green-600"></i>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-8 pt-6 text-center text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} APK Premium. All Rights Reserved. Made with <i class="fas fa-heart text-red-500"></i></p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
