@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold serif-font text-gray-800">Laporan Penjualan</h1>
    <p class="text-gray-500">Filter dan cetak laporan pendapatan toko.</p>
</div>

{{-- Form Filter --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
    <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
        
        <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Bulan (Opsional)</label>
            <select name="month" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#8b5a2b] focus:ring focus:ring-[#8b5a2b] focus:ring-opacity-50">
                <option value="">Semua Bulan</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tahun (Opsional)</label>
            <select name="year" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#8b5a2b] focus:ring focus:ring-[#8b5a2b] focus:ring-opacity-50">
                <option value="">Semua Tahun</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-1/3 flex gap-2">
            <button type="submit" class="w-1/2 bg-gray-800 hover:bg-black text-white px-4 py-2.5 rounded-xl font-medium transition">
                Filter Data
            </button>
            
            {{-- Tombol Cetak (Akan mengirim parameter print=true beserta filter yang aktif) --}}
            <button type="submit" name="print" value="true" formtarget="_blank" class="w-1/2 bg-[#8b5a2b] hover:bg-amber-900 text-white px-4 py-2.5 rounded-xl font-medium transition flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Cetak PDF
            </button>
        </div>
    </form>
</div>

{{-- Tabel Data --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Total Pendapatan: <span class="text-[#8b5a2b]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span></h2>
        <span class="text-sm text-gray-500">Menampilkan {{ $orders->count() }} transaksi sukses</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-white text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-6 py-4 border-b">Tanggal</th>
                    <th class="text-left px-6 py-4 border-b">No. Pesanan</th>
                    <th class="text-left px-6 py-4 border-b">Pelanggan</th>
                    <th class="text-right px-6 py-4 border-b">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $order->order_number }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-800">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">Tidak ada data transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    {{-- Enhanced Reporting Features --}}
    <div class="mt-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Laporan Lengkap</h2>
            <div class="space-y-4">
                <button onclick="showReportTypeModal()" class="w-full text-left bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg font-medium text-gray-700 transition">
                    📊 Laporan Penjualan Detail
                </button>
                <button onclick="showProductReportModal()" class="w-full text-left bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg font-medium text-gray-700 transition">
                    📦 Laporan Produk Terlaris
                </button>
                <button onclick="showCustomerReportModal()" class="w-full text-left bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg font-medium text-gray-700 transition">
                    👥 Laporan Pelanggan
                </button>
                <a href="{{ route('admin.reports.stock') }}" class="w-full text-left bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg font-medium text-gray-700 transition block">
                    📦 Laporan Stok Inventory
                </a>
            </div>
        </div>
    </div>

    {{-- Report Modals --}}
    <div id="reportTypeModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Laporan Penjualan Detail</h2>
                <button onclick="hideReportTypeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <form id="detailedReportForm" action="{{ route('admin.reports.index') }}" method="GET" class="space-y-4">
                @csrf
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Jenis Laporan:</label>
                    <select name="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]">
                        <option value="sales">Penjualan Harian</option>
                        <option value="monthly">Penjualan Bulanan</option>
                        <option value="category">Berdasarkan Kategori</option>
                        <option value="payment">Berdasarkan Metode Pembayaran</option>
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Format Output:</label>
                    <div class="flex space-x-3">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="output_format" value="html" checked class="form-radio text-[#8b5a2b]">
                            <span>HTML</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="output_format" value="pdf" class="form-radio text-[#8b5a2b]">
                            <span>PDF</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="hideReportTypeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#8b5a2b] text-white rounded-md hover:bg-black">Generate Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Produk Terlaris -->
    <div id="productReportModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Laporan Produk Terlaris</h2>
                <button onclick="hideProductReportModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div class="space-y-4">
                <p class="text-sm text-gray-600">Menampilkan produk berdasarkan jumlah terjual.</p>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-2">Top 10 Produk Terlaris</h3>
                    @php
                        $topProducts = \App\Models\OrderItem::selectRaw('product_name, SUM(quantity) as total_sold, SUM(subtotal) as total_revenue')
                            ->groupBy('product_name')
                            ->orderByDesc('total_sold')
                            ->limit(10)
                            ->get();
                    @endphp
                    @if($topProducts->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada data penjualan.</p>
                    @else
                        <ol class="list-decimal list-inside text-sm text-gray-700 space-y-1">
                            @foreach($topProducts as $idx => $p)
                                <li><span class="font-medium">{{ $p->product_name }}</span> — {{ $p->total_sold }} terjual (Rp {{ number_format($p->total_revenue, 0, ',', '.') }})</li>
                            @endforeach
                        </ol>
                    @endif
                </div>
                <button onclick="hideProductReportModal()" class="w-full bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 transition font-medium">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Pelanggan -->
    <div id="customerReportModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Laporan Pelanggan</h2>
                <button onclick="hideCustomerReportModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div class="space-y-4">
                <p class="text-sm text-gray-600">Ringkasan aktivitas pelanggan.</p>
                @php
                    $totalUsers = \App\Models\User::where('role', 'customer')->count();
                    $totalOrders = \App\Models\Order::where('payment_status', 'paid')->count();
                    $topCustomers = \App\Models\User::withCount(['orders as paid_orders' => function($q) { $q->where('payment_status', 'paid'); }])
                        ->where('role', 'customer')
                        ->orderByDesc('paid_orders')
                        ->limit(5)
                        ->get();
                @endphp
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-blue-50 rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-blue-700">{{ $totalUsers }}</div>
                        <div class="text-xs text-blue-500">Total Pelanggan</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-green-700">{{ $totalOrders }}</div>
                        <div class="text-xs text-green-500">Total Pesanan Dibayar</div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-2">Top 5 Pelanggan Aktif</h3>
                    @if($topCustomers->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada data pelanggan.</p>
                    @else
                        <ol class="list-decimal list-inside text-sm text-gray-700 space-y-1">
                            @foreach($topCustomers as $c)
                                <li><span class="font-medium">{{ $c->name }}</span> — {{ $c->paid_orders }} pesanan</li>
                            @endforeach
                        </ol>
                    @endif
                </div>
                <button onclick="hideCustomerReportModal()" class="w-full bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 transition font-medium">Tutup</button>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
<script>
    function showReportTypeModal() {
        document.getElementById('reportTypeModal').classList.remove('hidden');
    }
    
    function hideReportTypeModal() {
        document.getElementById('reportTypeModal').classList.add('hidden');
    }

    function showProductReportModal() {
        document.getElementById('productReportModal').classList.remove('hidden');
    }

    function hideProductReportModal() {
        document.getElementById('productReportModal').classList.add('hidden');
    }

    function showCustomerReportModal() {
        document.getElementById('customerReportModal').classList.remove('hidden');
    }

    function hideCustomerReportModal() {
        document.getElementById('customerReportModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        ['reportTypeModal', 'productReportModal', 'customerReportModal'].forEach(id => {
            const modal = document.getElementById(id);
            if (event.target === modal) modal.classList.add('hidden');
        });
    }
</script>
@endpush