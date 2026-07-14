<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Inventaris - UMKM KITA</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
            background: #fff;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm 18mm;
            position: relative;
        }

        /* === HEADER === */
        .report-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3e2723;
            position: relative;
        }

        .report-header::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 120px;
            height: 3px;
            background: #8b5a2b;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #3e2723 0%, #5d4037 50%, #8b5a2b 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: -0.5px;
            box-shadow: 0 4px 12px rgba(62, 39, 35, 0.3);
        }

        .brand-text h1 {
            font-size: 22px;
            font-weight: 800;
            color: #3e2723;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-text p {
            font-size: 10px;
            color: #8b5a2b;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .report-meta {
            text-align: right;
        }

        .report-badge {
            display: inline-block;
            background: #3e2723;
            color: #fff;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .report-meta .date {
            font-size: 11px;
            color: #6b7280;
        }

        .report-meta .date strong {
            color: #374151;
        }

        /* === TITLE SECTION === */
        .title-section {
            background: linear-gradient(135deg, #f8f6f4 0%, #f4eee6 100%);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 24px;
            border: 1px solid #e5ddd3;
        }

        .title-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #3e2723;
            margin-bottom: 4px;
        }

        .title-section .subtitle {
            font-size: 12px;
            color: #8b5a2b;
            font-weight: 500;
        }

        .title-section .period {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            background: #fff;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid #e5ddd3;
            font-size: 11px;
            color: #374151;
        }

        .title-section .period strong {
            color: #3e2723;
        }

        /* === SUMMARY CARDS === */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .summary-card.gray::before { background: #6b7280; }
        .summary-card.amber::before { background: #f59e0b; }
        .summary-card.red::before { background: #ef4444; }
        .summary-card.brown::before { background: #8b5a2b; }

        .summary-card .icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .summary-card.gray .icon { background: #f3f4f6; color: #6b7280; }
        .summary-card.amber .icon { background: #fffbeb; color: #f59e0b; }
        .summary-card.red .icon { background: #fef2f2; color: #ef4444; }
        .summary-card.brown .icon { background: #f4eee6; color: #8b5a2b; }

        .summary-card .label {
            font-size: 9px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .summary-card .value {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
        }

        .summary-card .value.currency::before {
            content: 'Rp ';
            font-size: 13px;
            font-weight: 500;
            color: #6b7280;
        }

        .summary-card .count {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }

        /* === STATUS LEGEND === */
        .status-legend {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
            padding: 10px 16px;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            color: #6b7280;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .legend-dot.green { background: #10b981; }
        .legend-dot.amber { background: #f59e0b; }
        .legend-dot.red { background: #ef4444; }

        /* === TABLE === */
        .table-container {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-header h3 {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
        }

        .table-header .badge {
            font-size: 10px;
            color: #6b7280;
            background: #e5e7eb;
            padding: 2px 10px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #3e2723;
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 10px 14px;
            text-align: left;
        }

        thead th:first-child { border-top-left-radius: 0; }
        thead th:last-child { border-top-right-radius: 0; text-align: right; }

        tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* === STOCK STATUS BADGES === */
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }

        .stock-badge.out {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .stock-badge.low {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fed7aa;
        }

        .stock-badge.normal {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .product-name {
            font-weight: 600;
            color: #111827;
        }

        .category-tag {
            display: inline-block;
            font-size: 10px;
            color: #6b7280;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .amount {
            font-weight: 600;
            color: #374151;
        }

        /* === TOTAL FOOTER === */
        .table-footer {
            background: #f9fafb;
            border-top: 2px solid #3e2723;
        }

        .table-footer td {
            padding: 14px;
            font-weight: 700;
            font-size: 13px;
        }

        .total-label {
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 11px;
        }

        .total-value {
            color: #3e2723;
            font-size: 16px;
        }

        /* === SIGNATURE === */
        .signature-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
            padding-top: 20px;
        }

        .signature-box {
            width: 220px;
            text-align: center;
        }

        .signature-box .location {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .signature-box .role {
            font-size: 10px;
            color: #9ca3af;
            margin-bottom: 60px;
        }

        .signature-line {
            border-top: 1px solid #d1d5db;
            padding-top: 8px;
        }

        .signature-name {
            font-size: 12px;
            font-weight: 700;
            color: #3e2723;
        }

        .signature-title {
            font-size: 10px;
            color: #6b7280;
        }

        /* === FOOTER NOTE === */
        .footer-note {
            margin-top: 30px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-note p {
            font-size: 9px;
            color: #9ca3af;
        }

        .footer-note .logo-small {
            font-weight: 700;
            color: #3e2723;
            font-size: 10px;
        }

        /* === PRINT STYLES === */
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 0; }
            .page { padding: 10mm 15mm; margin: 0; width: 100%; }
            .summary-card { break-inside: avoid; }
            tbody tr { break-inside: avoid; }
        }

        /* === INSTRUCTIONS BANNER === */
        .instructions {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #1e40af;
        }

        .instructions strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .no-print buttons {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            padding: 8px 18px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-print {
            background: #3e2723;
            color: #fff;
        }

        .btn-print:hover {
            background: #5d4037;
        }

        .btn-close {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-close:hover {
            background: #d1d5db;
        }
    </style>
</head>
<body>

    <div class="page">

        <div class="no-print">
            <div class="instructions">
                <strong>Cara Simpan sebagai PDF:</strong>
                Tekan <kbd>Ctrl + P</kbd> (atau <kbd>Cmd + P</kbd> di Mac), ubah "Destination" menjadi <strong>"Save as PDF"</strong>, lalu klik Save.
                <br>
                <button class="btn-print" onclick="window.print()">Cetak / Simpan PDF</button>
                <button class="btn-close" onclick="window.close()">Tutup</button>
            </div>
        </div>

        {{-- Header --}}
        <div class="report-header">
            <div class="brand">
                <div class="brand-logo">U</div>
                <div class="brand-text">
                    <h1>UMKM KITA</h1>
                    <p>Marketplace Kuliner Lokal</p>
                </div>
            </div>
            <div class="report-meta">
                <div class="report-badge">Laporan Inventaris</div>
                <p class="date">Dicetak: <strong>{{ now()->translatedFormat('d F Y') }}</strong></p>
                <p class="date">Pukul: <strong>{{ now()->format('H:i') }} WIB</strong></p>
            </div>
        </div>

        {{-- Title Section --}}
        <div class="title-section">
            <h2>Laporan Stok & Inventaris Produk</h2>
            <p class="subtitle">Status persediaan seluruh produk di gudang UMKM KITA</p>
            <div class="period">
                <svg width="14" height="14" fill="none" stroke="#8b5a2b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Periode: <strong>
                @if(request('month') || request('year'))
                    {{ request('month') ? date('F', mktime(0, 0, 0, request('month'), 10)) : 'Semua Bulan' }}
                    {{ request('year') ?? 'Semua Tahun' }}
                @else
                    Keseluruhan (Semua Waktu)
                @endif
                </strong>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="summary-grid">
            <div class="summary-card gray">
                <div class="label">Total Produk</div>
                <div class="value">{{ $totalProducts }}</div>
                <div class="count">semua produk terdaftar</div>
            </div>
            <div class="summary-card amber">
                <div class="label">Stok Rendah</div>
                <div class="value" style="color: #d97706;">{{ $lowStockProducts }}</div>
                <div class="count">stok di bawah 10</div>
            </div>
            <div class="summary-card red">
                <div class="label">Habis Stok</div>
                <div class="value" style="color: #dc2626;">{{ $outOfStockProducts }}</div>
                <div class="count">perlu restok segera</div>
            </div>
            <div class="summary-card brown">
                <div class="label">Nilai Inventaris</div>
                <div class="value currency">{{ number_format($totalInventoryValue, 0, ',', '.') }}</div>
                <div class="count">total nilai stok</div>
            </div>
        </div>

        {{-- Status Legend --}}
        <div class="status-legend">
            <div class="legend-item">
                <div class="legend-dot green"></div>
                <span>Stok Normal (&ge; 10)</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot amber"></div>
                <span>Stok Rendah (1 - 9)</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot red"></div>
                <span>Habis Stok (0)</span>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="table-container">
            <div class="table-header">
                <h3>Daftar Produk & Stok</h3>
                <span class="badge">{{ $totalProducts }} produk</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="22%">Nama Produk</th>
                        <th width="16%">Kategori</th>
                        <th class="text-center" width="10%">Stok</th>
                        <th class="text-center" width="12%">Status</th>
                        <th class="text-right" width="14%">Harga (Rp)</th>
                        <th class="text-right" width="16%">Nilai Stok (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        @php
                            $stockClass = $product->stock == 0 ? 'out' : ($product->stock < 10 ? 'low' : 'normal');
                            $stockLabel = $product->stock == 0 ? 'Habis' : ($product->stock < 10 ? 'Rendah' : 'Normal');
                        @endphp
                        <tr>
                            <td class="text-center" style="color: #9ca3af; font-size: 10px;">{{ $index + 1 }}</td>
                            <td><span class="product-name">{{ $product->name }}</span></td>
                            <td><span class="category-tag">{{ $product->category->name ?? 'Tanpa Kategori' }}</span></td>
                            <td class="text-center" style="font-weight: 700; font-size: 13px;">{{ $product->stock }}</td>
                            <td class="text-center">
                                <span class="stock-badge {{ $stockClass }}">{{ $stockLabel }}</span>
                            </td>
                            <td class="text-right amount">{{ number_format($product->discount_price, 0, ',', '.') }}</td>
                            <td class="text-right amount">{{ number_format($product->stock * $product->discount_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 30px; color: #9ca3af;">
                                Tidak ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($products->count() > 0)
                <tfoot>
                    <tr class="table-footer">
                        <td colspan="3" class="text-right total-label">Total</td>
                        <td class="text-center" style="font-size: 14px; color: #3e2723;">{{ $products->sum('stock') }}</td>
                        <td></td>
                        <td class="text-right total-label">Nilai Inventaris</td>
                        <td class="text-right total-value">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        {{-- Signature --}}
        <div class="signature-section">
            <div class="signature-box">
                <p class="location">Batam, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="role">Mengetahui,</p>
                <div class="signature-line">
                    <p class="signature-name">{{ Auth::user()->name ?? 'Admin UMKM KITA' }}</p>
                    <p class="signature-title">Administrator</p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer-note">
            <p>Dokumen ini dicetak secara otomatis oleh sistem UMKM KITA.</p>
            <p class="logo-small">UMKM KITA &copy; {{ date('Y') }}</p>
        </div>

    </div>

</body>
</html>
