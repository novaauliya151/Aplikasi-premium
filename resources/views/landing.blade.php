@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600 text-white py-20 rounded-3xl mb-12 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=60 height=60 viewBox=0 0 60 60 xmlns=http://www.w3.org/2000/svg%3E%3Cg fill=none fill-rule=evenodd%3E%3Cg fill=%23ffffff fill-opacity=0.05%3E%3Cpath d=M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative max-w-5xl mx-auto px-6 text-center">
        <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-6">
            <span class="text-sm font-semibold"><i class="fas fa-star mr-2"></i>Platform Aplikasi Premium Terpercaya</span>
        </div>
        
        <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
            Dapatkan Aplikasi<br>
            <span class="text-yellow-300">Premium</span> dengan Harga Terjangkau
        </h1>
        
        <p class="text-xl text-green-50 mb-8 max-w-3xl mx-auto">
            Akses ribuan aplikasi premium original dengan lisensi resmi. 
            Hemat hingga 70% dengan jaminan update gratis selamanya!
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/product" class="bg-white text-green-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center">
                <i class="fas fa-shopping-bag mr-2"></i>
                Lihat Produk
            </a>
            <a href="#how-it-works" class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-green-600 transition-all duration-300 flex items-center">
                <i class="fas fa-play-circle mr-2"></i>
                Cara Kerja
            </a>
        </div>
        
        <div class="grid grid-cols-3 gap-8 mt-16 max-w-3xl mx-auto">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <h3 class="text-3xl font-bold mb-1">500+</h3>
                <p class="text-sm text-green-50">Aplikasi Tersedia</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <h3 class="text-3xl font-bold mb-1">10K+</h3>
                <p class="text-sm text-green-50">Pengguna Aktif</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <h3 class="text-3xl font-bold mb-1">4.9/5</h3>
                <p class="text-sm text-green-50">Rating Kepuasan</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="mb-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Kenapa Pilih Kami?</h2>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Kami menyediakan solusi terbaik untuk kebutuhan aplikasi premium Anda
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow border border-gray-100">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-3">100% Original</h3>
            <p class="text-gray-600">Semua aplikasi dijamin original dengan lisensi resmi dari developer</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow border border-gray-100">
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-sync-alt text-blue-600 text-2xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-3">Update Gratis</h3>
            <p class="text-gray-600">Dapatkan update terbaru tanpa biaya tambahan selamanya</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow border border-gray-100">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-headset text-purple-600 text-2xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-3">Support 24/7</h3>
            <p class="text-gray-600">Tim support siap membantu Anda kapan saja melalui chat atau email</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow border border-gray-100">
            <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-undo text-yellow-600 text-2xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-3">Garansi 30 Hari</h3>
            <p class="text-gray-600">Tidak puas? Kami kembalikan 100% uang Anda tanpa pertanyaan</p>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="mb-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 md:p-12">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Cara Belinya Gampang Banget!</h2>
        <p class="text-gray-600 text-lg">Hanya 3 langkah mudah untuk mendapatkan aplikasi premium impian Anda</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <div class="text-center">
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6 shadow-lg">
                1
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-3">Pilih Aplikasi</h3>
            <p class="text-gray-600">Jelajahi katalog kami dan pilih aplikasi yang Anda butuhkan</p>
        </div>
        
        <div class="text-center">
            <div class="bg-gradient-to-br from-blue-500 to-cyan-600 text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6 shadow-lg">
                2
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-3">Checkout & Bayar</h3>
            <p class="text-gray-600">Isi data dan lakukan pembayaran melalui transfer bank atau e-wallet</p>
        </div>
        
        <div class="text-center">
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6 shadow-lg">
                3
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-3">Terima Akses</h3>
            <p class="text-gray-600">Akses aplikasi langsung dikirim ke email Anda dalam hitungan menit!</p>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="mb-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Apa Kata Mereka?</h2>
        <p class="text-gray-600 text-lg">Ribuan pelanggan puas telah mempercayai kami</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="flex text-yellow-500 mb-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <p class="text-gray-700 mb-4 italic">"Pelayanan cepat dan harga sangat terjangkau. Aplikasi langsung bisa dipakai dan updatenya gratis! Recommended banget!"</p>
            <div class="flex items-center">
                <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user text-green-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Budi Santoso</p>
                    <p class="text-sm text-gray-600">Entrepreneur</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="flex text-yellow-500 mb-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <p class="text-gray-700 mb-4 italic">"Sudah beli 5 aplikasi disini, semuanya original dan support-nya responsif. Terima kasih APK Premium!"</p>
            <div class="flex items-center">
                <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Siti Nurhaliza</p>
                    <p class="text-sm text-gray-600">Designer</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="flex text-yellow-500 mb-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <p class="text-gray-700 mb-4 italic">"Proses pembelian mudah dan cepat. Harga jauh lebih murah dari official tapi tetap legal. Top!"</p>
            <div class="flex items-center">
                <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user text-purple-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Ahmad Fauzi</p>
                    <p class="text-sm text-gray-600">Developer</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="mb-16 bg-white rounded-3xl p-8 md:p-12 shadow-lg">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Ditanyakan</h2>
        <p class="text-gray-600 text-lg">Punya pertanyaan? Kami punya jawabannya!</p>
    </div>
    
    <div class="max-w-3xl mx-auto space-y-4">
        <details class="group bg-gray-50 rounded-xl p-6 cursor-pointer hover:bg-gray-100 transition-colors">
            <summary class="font-bold text-lg text-gray-900 flex items-center justify-between">
                Apakah aplikasi yang dijual original?
                <i class="fas fa-chevron-down group-open:rotate-180 transition-transform text-green-600"></i>
            </summary>
            <p class="text-gray-600 mt-4 leading-relaxed">
                Ya, 100% original! Semua aplikasi yang kami jual memiliki lisensi resmi dari developer/publisher asli. Kami tidak menjual aplikasi bajakan atau crack.
            </p>
        </details>
        
        <details class="group bg-gray-50 rounded-xl p-6 cursor-pointer hover:bg-gray-100 transition-colors">
            <summary class="font-bold text-lg text-gray-900 flex items-center justify-between">
                Berapa lama akses aplikasi dikirim?
                <i class="fas fa-chevron-down group-open:rotate-180 transition-transform text-green-600"></i>
            </summary>
            <p class="text-gray-600 mt-4 leading-relaxed">
                Setelah pembayaran dikonfirmasi, akses aplikasi akan langsung dikirim ke email Anda dalam waktu maksimal 15 menit. Proses biasanya otomatis dan sangat cepat!
            </p>
        </details>
        
        <details class="group bg-gray-50 rounded-xl p-6 cursor-pointer hover:bg-gray-100 transition-colors">
            <summary class="font-bold text-lg text-gray-900 flex items-center justify-between">
                Bagaimana cara pembayarannya?
                <i class="fas fa-chevron-down group-open:rotate-180 transition-transform text-green-600"></i>
            </summary>
            <p class="text-gray-600 mt-4 leading-relaxed">
                Kami menerima pembayaran via transfer bank (BCA, Mandiri, BRI, BNI) dan e-wallet (OVO, Dana, GoPay, ShopeePay). Pilih metode yang paling nyaman untuk Anda!
            </p>
        </details>
        
        <details class="group bg-gray-50 rounded-xl p-6 cursor-pointer hover:bg-gray-100 transition-colors">
            <summary class="font-bold text-lg text-gray-900 flex items-center justify-between">
                Apakah ada garansi jika tidak puas?
                <i class="fas fa-chevron-down group-open:rotate-180 transition-transform text-green-600"></i>
            </summary>
            <p class="text-gray-600 mt-4 leading-relaxed">
                Tentu! Kami memberikan garansi uang kembali 30 hari. Jika Anda tidak puas dengan pembelian, kami akan refund 100% tanpa pertanyaan.
            </p>
        </details>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-3xl p-12 text-center">
    <h2 class="text-4xl font-bold mb-4">Siap Upgrade Aplikasi Anda?</h2>
    <p class="text-xl text-green-50 mb-8 max-w-2xl mx-auto">
        Bergabunglah dengan ribuan pengguna yang sudah merasakan kemudahan dan hemat dengan aplikasi premium dari kami!
    </p>
    <a href="/product" class="inline-block bg-white text-green-600 px-10 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl">
        <i class="fas fa-rocket mr-2"></i>
        Mulai Sekarang
    </a>
</section>

@endsection
