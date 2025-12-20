@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li><a href="/" class="hover:text-green-600 transition-colors"><i class="fas fa-home"></i> Home</a></li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li class="text-gray-800 font-medium">Upload Pembayaran</li>
    </ol>
</nav>

<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 lg:p-8">
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 backdrop-blur rounded-full p-4">
                    <i class="fas fa-receipt text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold">Upload Bukti Pembayaran</h1>
                    <p class="text-green-50 mt-1">Order #{{ $order->order_number }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 lg:p-8">
            
            <!-- Order Details -->
            <div class="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-200">
                <h2 class="font-bold text-lg text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-shopping-bag text-green-600 mr-2"></i>Detail Pesanan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nomor Order</p>
                        <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Pembayaran</p>
                        <p class="font-bold text-green-600 text-xl">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Customer</p>
                        <p class="font-semibold text-gray-900">{{ $order->customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-clock mr-1"></i>Menunggu Pembayaran
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bank Info -->
            <div class="bg-blue-50 rounded-xl p-5 mb-6 border border-blue-200">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-university text-blue-600 mr-2"></i>Informasi Rekening
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between bg-white rounded-lg p-4 shadow-sm">
                        <div>
                            <p class="text-sm text-gray-600">Bank BCA</p>
                            <p class="font-bold text-lg text-gray-900">1234567890</p>
                            <p class="text-sm text-gray-700">a.n. APK Premium</p>
                        </div>
                        <button onclick="copyText('1234567890')" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                            <i class="fas fa-copy mr-1"></i>Copy
                        </button>
                    </div>
                    <div class="flex items-center justify-between bg-white rounded-lg p-4 shadow-sm">
                        <div>
                            <p class="text-sm text-gray-600">Bank Mandiri</p>
                            <p class="font-bold text-lg text-gray-900">0987654321</p>
                            <p class="text-sm text-gray-700">a.n. APK Premium</p>
                        </div>
                        <button onclick="copyText('0987654321')" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                            <i class="fas fa-copy mr-1"></i>Copy
                        </button>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-cloud-upload-alt text-green-600 mr-1"></i>Upload Bukti Pembayaran *
                    </label>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-500 transition-colors cursor-pointer" id="dropZone">
                        <div id="preview" class="hidden mb-4">
                            <img id="previewImage" class="max-h-48 mx-auto rounded-lg shadow-md">
                        </div>
                        <div id="uploadPrompt">
                            <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-3"></i>
                            <p class="text-gray-700 font-medium mb-2">Klik untuk upload atau drag & drop</p>
                            <p class="text-sm text-gray-500">Format: JPG, PNG, PDF (Max: 2MB)</p>
                        </div>
                        <input type="file" 
                               name="payment_proof" 
                               id="fileInput"
                               accept="image/jpeg,image/png,application/pdf"
                               required
                               class="hidden">
                    </div>
                    @error('payment_proof')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instructions -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-yellow-600 mr-2"></i>Petunjuk Upload
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-0.5 mr-2"></i>
                            <span>Pastikan bukti transfer terlihat jelas dan tidak buram</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-0.5 mr-2"></i>
                            <span>Nominal transfer harus sesuai dengan total pesanan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-0.5 mr-2"></i>
                            <span>Konfirmasi akan diproses maksimal 1x24 jam</span>
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-xl text-lg font-bold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Upload Bukti Pembayaran</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="/product" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </div>
</div>

<!-- Scripts -->
<script>
    // Copy to clipboard function
    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening berhasil disalin!');
        });
    }

    // File upload preview
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const preview = document.getElementById('preview');
    const previewImage = document.getElementById('previewImage');
    const uploadPrompt = document.getElementById('uploadPrompt');

    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
                uploadPrompt.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-green-500', 'bg-green-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-green-500', 'bg-green-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    });
</script>

@endsection
