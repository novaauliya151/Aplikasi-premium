<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} - APK Premium</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-[Inter]">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR DESKTOP -->
    <aside class="hidden md:flex w-64 flex-col bg-gradient-to-b from-green-600 to-emerald-700 text-white">

        <!-- LOGO -->
        <div class="p-6 border-b border-green-700 flex items-center gap-3">
            <div class="bg-white p-2 rounded-lg">
                <i class="fas fa-rocket text-green-600 text-xl"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg">APK Premium</h1>
                <p class="text-xs text-green-200">Admin Panel</p>
            </div>
        </div>

        <!-- MENU -->
        <nav class="flex-1 p-4 space-y-1">

            @php
                $link = 'flex items-center gap-3 px-4 py-3 rounded-lg text-gray-200 hover:bg-green-700 hover:text-white transition';
                $active = 'bg-green-700 text-white font-semibold';
            @endphp

            <a href="/admin/dashboard" class="{{ $link }} {{ request()->is('admin/dashboard') ? $active : '' }}">
                <i class="fas fa-chart-line w-5 text-center"></i> Dashboard
            </a>

            <a href="/admin/products" class="{{ $link }} {{ request()->is('admin/products*') ? $active : '' }}">
                <i class="fas fa-box w-5 text-center"></i> Produk
            </a>

            <a href="/admin/orders" class="{{ $link }} {{ request()->is('admin/orders*') ? $active : '' }}">
                <i class="fas fa-shopping-cart w-5 text-center"></i> Pesanan
            </a>

            <a href="/admin/payments" class="{{ $link }} {{ request()->is('admin/payments*') ? $active : '' }}">
                <i class="fas fa-credit-card w-5 text-center"></i> Pembayaran
                @if(isset($pendingPaymentsCount) && $pendingPaymentsCount > 0)
                <span class="ml-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingPaymentsCount }}</span>
                @endif
            </a>

            <a href="/admin/customers" class="{{ $link }} {{ request()->is('admin/customers*') ? $active : '' }}">
                <i class="fas fa-users w-5 text-center"></i> Pelanggan
            </a>

            <div class="pt-4 mt-4 border-t border-green-700">
                <a href="/" target="_blank" class="{{ $link }}">
                    <i class="fas fa-globe w-5 text-center"></i> Lihat Website
                </a>
            </div>
        </nav>

        <!-- USER -->
        <div class="p-4 border-t border-green-700">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-green-200">Administrator</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg text-sm font-semibold">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
            <button id="menuBtn" class="md:hidden text-gray-600">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <p class="hidden sm:block text-sm text-gray-500">
                {{ now()->format('l, d F Y') }}
            </p>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

<!-- MOBILE OVERLAY -->
<div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40"></div>

<!-- MOBILE SIDEBAR -->
<aside id="mobileSidebar"
       class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-green-600 to-emerald-700
              text-white transform -translate-x-full transition z-50 md:hidden">

    <div class="p-6 border-b border-green-700 flex justify-between items-center">
        <h1 class="font-bold">APK Premium</h1>
        <button id="closeSidebar"><i class="fas fa-times"></i></button>
    </div>

    <nav class="p-4 space-y-1">
        <a href="/admin/dashboard" class="{{ $link }}">Dashboard</a>
        <a href="/admin/products" class="{{ $link }}">Produk</a>
        <a href="/admin/orders" class="{{ $link }}">Pesanan</a>
        <a href="/admin/payments" class="{{ $link }} flex items-center justify-between">
            <span>Pembayaran</span>
            @if(isset($pendingPaymentsCount) && $pendingPaymentsCount > 0)
            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingPaymentsCount }}</span>
            @endif
        </a>
        <a href="/admin/customers" class="{{ $link }}">Pelanggan</a>
    </nav>
</aside>

<script>
    const btn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('overlay');
    const close = document.getElementById('closeSidebar');

    btn.onclick = () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    };
    close.onclick = overlay.onclick = () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    };
</script>

</body>
</html>
