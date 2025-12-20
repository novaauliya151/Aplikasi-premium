@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Verifikasi Pembayaran</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
<table class="w-full">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="p-3 text-left">Order #</th>
            <th class="p-3 text-left">Customer</th>
            <th class="p-3 text-left">Produk</th>
            <th class="p-3 text-right">Total</th>
            <th class="p-3 text-center">Tanggal</th>
            <th class="p-3 text-center">Bukti</th>
            <th class="p-3 text-center">Status</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
        <tr class="border-b hover:bg-gray-50">
            <td class="p-3">
                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline font-semibold">
                    #{{ $order->order_number }}
                </a>
            </td>
            <td class="p-3">
                <div class="font-medium">{{ $order->customer->name ?? $order->name }}</div>
                <div class="text-sm text-gray-500">{{ $order->customer->email ?? $order->email }}</div>
            </td>
            <td class="p-3">
                <div class="text-sm">
                    @foreach($order->items as $item)
                        <div>{{ $item->product->name }} @if($item->variant_name)({{ $item->variant_name }})@endif x{{ $item->quantity }}</div>
                    @endforeach
                </div>
            </td>
            <td class="p-3 text-right font-semibold">Rp {{ number_format($order->total,0,',','.') }}</td>
            <td class="p-3 text-center text-sm text-gray-600">
                {{ $order->created_at->format('d M Y H:i') }}
            </td>
            <td class="p-3 text-center">
                @if($order->payment_proof)
                <button onclick="showImageModal('{{ asset('storage/'.$order->payment_proof) }}', '{{ $order->order_number }}')" 
                        class="inline-flex items-center gap-1 bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                    <i class="fas fa-image"></i> Lihat
                </button>
                @else
                <span class="text-gray-400 text-sm">Belum upload</span>
                @endif
            </td>
            <td class="p-3 text-center">
                @if($order->payment_status == 'awaiting_verification')
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Menunggu Verifikasi</span>
                @elseif($order->payment_status == 'verified')
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Terverifikasi</span>
                @elseif($order->payment_status == 'rejected')
                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Ditolak</span>
                @else
                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-semibold">Pending</span>
                @endif
            </td>
            <td class="p-3 text-center">

                <!-- Verifikasi -->
                @if($order->payment_status == 'awaiting_verification')
                <form action="{{ route('admin.payments.verify', $order->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="action" value="verify">
                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">✓ Terima</button>
                </form>
                <form action="{{ route('admin.payments.verify', $order->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">✗ Tolak</button>
                </form>
                @endif

                <!-- Kirim akses -->
                @if($order->payment_status == 'verified' && !$order->access_sent_at)
                <form action="{{ route('admin.payments.sendAccess', $order->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">📤 Kirim Akses</button>
                </form>
                @elseif($order->access_sent_at)
                <span class="text-green-600 text-sm">✓ Akses terkirim</span>
                @endif

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="p-8 text-center text-gray-500">
                <div class="text-4xl mb-2">📭</div>
                <div>Tidak ada pembayaran yang perlu diverifikasi</div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

@if($orders->hasPages())
<div class="mt-4">
    {{ $orders->links() }}
</div>
@endif

<!-- Modal Preview Bukti Pembayaran -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl w-full bg-white rounded-lg p-4" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold" id="modalTitle">Bukti Pembayaran</h3>
            <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="max-h-[70vh] overflow-auto flex items-center justify-center bg-gray-50 rounded">
            <img id="modalImage" src="" alt="Bukti Pembayaran" class="w-full h-auto" 
                 onload="document.getElementById('modalError').style.display='none';"
                 onerror="this.style.display='none'; document.getElementById('modalError').style.display='block';">
            <div id="modalError" style="display:none;" class="text-center py-8 text-red-500">
                <i class="fas fa-exclamation-triangle text-5xl mb-3"></i>
                <p class="font-semibold text-lg">Gagal memuat gambar</p>
                <p class="text-sm mt-2">Silakan coba buka di tab baru</p>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-600 bg-gray-50 p-3 rounded">
            <p id="modalImageUrl" class="break-all font-mono text-xs"></p>
            <a id="modalDownloadLink" href="" target="_blank" class="inline-block mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-external-link-alt mr-1"></i>Buka di Tab Baru
            </a>
        </div>
    </div>
</div>

<script>
function showImageModal(imageUrl, orderNumber) {
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalTitle').textContent = 'Bukti Pembayaran - Order #' + orderNumber;
    document.getElementById('modalImageUrl').textContent = 'URL: ' + imageUrl;
    document.getElementById('modalDownloadLink').href = imageUrl;
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('modalImage').src = '';
}

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
