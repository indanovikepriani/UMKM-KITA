@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Page Title --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan performa toko UMKM KITA bulan ini.</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Total Sales --}}
        <div class="kpi-card bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @php $dir = $trends['sales'] >= 0; @endphp
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $dir ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $dir ? '+' : '' }}{{ $trends['sales'] }}%
                </span>
            </div>
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Total Sales</p>
            <p class="text-xl font-bold text-gray-800">Rp {{ number_format($kpi['total_sales'], 0, ',', '.') }}</p>
        </div>

        {{-- Total Purchases --}}
        <div class="kpi-card bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                @php $dir = $trends['purchases'] >= 0; @endphp
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $dir ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $dir ? '+' : '' }}{{ $trends['purchases'] }}%
                </span>
            </div>
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Total Purchases</p>
            <p class="text-xl font-bold text-gray-800">{{ number_format($kpi['total_purchases'], 0, ',', '.') }} item</p>
        </div>

        {{-- Total Paid --}}
        <div class="kpi-card bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @php $dir = $trends['paid'] >= 0; @endphp
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $dir ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $dir ? '+' : '' }}{{ $trends['paid'] }}%
                </span>
            </div>
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Total Paid</p>
            <p class="text-xl font-bold text-gray-800">Rp {{ number_format($kpi['total_paid'], 0, ',', '.') }}</p>
        </div>

        {{-- Profits --}}
        <div class="kpi-card bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                @php $dir = $trends['profit'] >= 0; @endphp
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $dir ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ $dir ? '+' : '' }}{{ $trends['profit'] }}%
                </span>
            </div>
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Profits</p>
            <p class="text-xl font-bold text-gray-800">Rp {{ number_format($kpi['total_profit'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        {{-- Sales Trend Chart (2/3 width) --}}
        <div class="lg:col-span-2 bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Grafik Tren Penjualan</h3>
            <div style="height: 220px;">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        {{-- Top Selling Products (1/3 width) --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Produk Terlaris</h3>
            <div style="height: 220px;">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Top Selling Products List --}}
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-700">Rincian Produk Terlaris</h3>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-[#8b5a2b] font-semibold hover:underline">Lihat Semua</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @forelse($topSellingProducts as $i => $product)
            @php
                $percentage = $totalSoldAll > 0 ? round(($product->sold_quantity / $totalSoldAll) * 100, 1) : 0;
            @endphp
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-[#8b5a2b] text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ $i + 1 }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                    <p class="text-[11px] text-gray-400">{{ $product->sold_quantity }} terjual</p>
                </div>
                <span class="text-[11px] font-bold text-[#8b5a2b]">{{ $percentage }}%</span>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-6 col-span-5">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>

    {{-- Inventory Management Table --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">Manajemen Inventaris Produk</h3>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-1.5 bg-[#8b5a2b] text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-[#6f4620] transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Product
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">ID</th>
                        <th class="text-left px-5 py-3 font-semibold">Name</th>
                        <th class="text-left px-5 py-3 font-semibold">Description</th>
                        <th class="text-left px-5 py-3 font-semibold">Category</th>
                        <th class="text-left px-5 py-3 font-semibold">Price</th>
                        <th class="text-left px-5 py-3 font-semibold">Stock</th>
                        <th class="text-right px-5 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($inventoryProducts as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 text-gray-400 font-mono text-xs">#{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-9 h-9 rounded-lg object-cover border border-gray-100">
                                <span class="font-medium text-gray-800">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-500 text-xs max-w-[200px] truncate">{{ Str::limit($product->description, 50) }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-medium px-2 py-1 bg-gray-100 text-gray-600 rounded-md">{{ $product->category->name ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-3">
                            @if($product->price && $product->price > $product->discount_price)
                                <p class="text-gray-400 line-through text-[11px]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="font-semibold text-[#8b5a2b] text-xs">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                            @else
                                <p class="font-semibold text-gray-800 text-xs">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if($product->stock == 0)
                                <span class="text-xs font-semibold px-2 py-1 bg-red-50 text-red-600 rounded-md">Habis</span>
                            @elseif($product->stock < 5)
                                <span class="text-xs font-semibold px-2 py-1 bg-amber-50 text-amber-600 rounded-md">{{ $product->stock }}</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 bg-green-50 text-green-600 rounded-md">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-1.5 text-gray-400 hover:text-[#8b5a2b] hover:bg-gray-100 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk {{ $product->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada produk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if($inventoryProducts->hasPages())
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $inventoryProducts->links() }}
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Sales Trend Line Chart ---
            const salesCtx = document.getElementById('salesTrendChart');
            if (salesCtx) {
                const monthlySales = @json($monthlySales);
                new Chart(salesCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: monthlySales.map(i => i.month),
                        datasets: [{
                            label: 'Penjualan',
                            data: monthlySales.map(i => i.total),
                            borderColor: '#8b5a2b',
                            backgroundColor: 'rgba(139, 90, 43, 0.08)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointBackgroundColor: '#8b5a2b',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 10 }, color: '#9ca3af', maxRotation: 0 }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f3f4f6' },
                                ticks: {
                                    font: { size: 10 },
                                    color: '#9ca3af',
                                    callback: function(v) { return 'Rp ' + (v/1000).toFixed(0) + 'k'; },
                                    maxTicksLimit: 5
                                }
                            }
                        }
                    }
                });
            }

            // --- Top Products Doughnut Chart ---
            const topCtx = document.getElementById('topProductsChart');
            if (topCtx) {
                const topProducts = @json($topSellingProducts);
                const colors = ['#8b5a2b', '#d4a574', '#3b82f6', '#10b981', '#f59e0b'];
                new Chart(topCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: topProducts.map(p => p.name),
                        datasets: [{
                            data: topProducts.map(p => p.sold_quantity),
                            backgroundColor: colors.slice(0, topProducts.length),
                            borderWidth: 2,
                            borderColor: '#fff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 10, padding: 8, font: { size: 10 }, usePointStyle: true }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush

@endsection
