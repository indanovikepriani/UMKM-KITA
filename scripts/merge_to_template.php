<?php
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;

$templatePath = __DIR__ . '/../IndaNovikepriani_2422019.docx';
$ssDir = __DIR__ . '/../public/screenshots/';
$outputPath = __DIR__ . '/../Makalah_UMKM_KITA_FINAL.docx';

$phpWord = new PhpWord();
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->setDefaultFontSize(12);

// Styles
$phpWord->addTitleStyle(1, ['name' => 'Times New Roman', 'size' => 14, 'bold' => true], ['alignment' => Jc::CENTER, 'spaceAfter' => 100, 'spaceBefore' => 200]);
$phpWord->addTitleStyle(2, ['name' => 'Times New Roman', 'size' => 13, 'bold' => true], ['alignment' => Jc::LEFT, 'spaceAfter' => 100, 'spaceBefore' => 150]);
$phpWord->addTitleStyle(3, ['name' => 'Times New Roman', 'size' => 12, 'bold' => true, 'italic' => true], ['alignment' => Jc::LEFT, 'spaceAfter' => 80, 'spaceBefore' => 100]);

$phpWord->addParagraphStyle('justify', ['alignment' => Jc::BOTH, 'spaceAfter' => 60, 'lineHeight' => 1.5, 'indentation' => ['firstLine' => 720]]);
$phpWord->addParagraphStyle('center', ['alignment' => Jc::CENTER, 'spaceAfter' => 60, 'lineHeight' => 1.5]);
$phpWord->addParagraphStyle('normal', ['alignment' => Jc::LEFT, 'spaceAfter' => 60, 'lineHeight' => 1.5]);
$phpWord->addParagraphStyle('listItemStyle', ['alignment' => Jc::BOTH, 'spaceAfter' => 40, 'lineHeight' => 1.5, 'indentation' => ['left' => 720]]);

function addP($section, $text, $style = 'normal', $bold = false, $size = 12) {
    $section->addText($text, ['name' => 'Times New Roman', 'size' => $size, 'bold' => $bold], $style);
}
function addJ($section, $text) {
    $section->addText($text, ['name' => 'Times New Roman', 'size' => 12], 'justify');
}
function addImg($section, $path, $label, $num) {
    if (!file_exists($path)) return false;
    $section->addTextBreak(1, null, 'center');
    $section->addText("Gambar $num: $label", ['name' => 'Times New Roman', 'size' => 10, 'italic' => true], 'center');
    $section->addImage($path, ['width' => 450, 'height' => 280, 'alignment' => Jc::CENTER]);
    return true;
}

$m = ['marginTop' => Converter::cmToTwip(3), 'marginBottom' => Converter::cmToTwip(3), 'marginLeft' => Converter::cmToTwip(3), 'marginRight' => Converter::cmToTwip(3)];

// ====== COVER ======
$sec = $phpWord->addSection($m);
for ($i = 0; $i < 6; $i++) $sec->addTextBreak(1, null, 'center');
addP($sec, 'MAKALAH', 'center', true, 14);
$sec->addTextBreak(1, null, 'center');
addP($sec, 'PEMROGRAMAN WEB FRAMEWORK', 'center', true, 16);
$sec->addTextBreak(1, null, 'center');
addP($sec, '"UMKM KITA"', 'center', true, 16);
addP($sec, 'Marketplace UMKM Berbasis Web dengan Laravel', 'center', false, 12);
$sec->addTextBreak(2, null, 'center');
addP($sec, 'Disusun Oleh:', 'center', false, 12);
$sec->addTextBreak(1, null, 'center');
addP($sec, 'Inda Novi Kepriani', 'center', true, 14);
addP($sec, '2422019', 'center', false, 12);
$sec->addTextBreak(2, null, 'center');
addP($sec, 'PROGRAM STUDI [Prodi]', 'center', true, 13);
addP($sec, 'FAKULTAS [Fakultas]', 'center', true, 13);
addP($sec, 'UNIVERSITAS [Universitas]', 'center', true, 13);
addP($sec, 'TAHUN 2026', 'center', true, 13);

// ====== KATA PENGANTAR ======
$sec->addPageBreak();
$sec = $phpWord->addSection($m);
$sec->addTitle('KATA PENGANTAR', 1);
$sec->addTextBreak(1, null, 'center');
addJ($sec, 'Puji syukur kehadirat Allah SWT atas rahmat dan karunia-Nya sehingga penulis dapat menyelesaikan makalah berjudul "UMKM KITA: Marketplace UMKM Berbasis Web dengan Laravel" ini dengan baik.');
addJ($sec, 'Makalah ini disusun untuk memenuhi tugas mata kuliah Pemrograman Web Framework serta memberikan gambaran pengembangan platform marketplace digital bagi UMKM di Indonesia, khususnya di Batam.');
addJ($sec, 'Penulis menyadari makalah ini masih jauh dari sempurna. Kritik dan saran yang membangun sangat penulis harapkan. Semoga makalah ini bermanfaat.');
$sec->addTextBreak(2, null, 'normal');
addP($sec, 'Batam, Juli 2026', 'normal', false, 12);
$sec->addTextBreak(2, null, 'normal');
addP($sec, 'Penulis', 'center', false, 12);

// ====== BAB I PENDAHULUAN ======
$sec->addPageBreak();
$sec = $phpWord->addSection($m);
$sec->addTitle('BAB I', 1);
$sec->addTitle('PENDAHULUAN', 1);
$sec->addTextBreak(1, null, 'normal');

$sec->addTitle('A. Latar Belakang', 3);
addJ($sec, 'Perkembangan teknologi informasi membawa perubahan signifikan di sektor ekonomi. UMKM berperan strategis dalam perekonomian Indonesia, namun masih banyak yang kesulitan memasarkan produk secara digital karena keterbatasan sumber daya, pengetahuan teknologi, dan modal.');
addJ($sec, 'Penulis mengembangkan "UMKM KITA", website marketplace yang menghubungkan UMKM dengan konsumen. Dibangun dengan Laravel 12, PHP 8.2, MySQL, dan Tailwind CSS.');

addImg($sec, $ssDir . 'home.png', 'Halaman Home UMKM KITA', 1);

$sec->addTitle('B. Rumusan Masalah', 3);
$sec->addListItem('Bagaimana merancang website marketplace UMKM yang mudah digunakan?', 0, null, 'listItemStyle');
$sec->addListItem('Fitur apa saja yang diperlukan dalam platform marketplace UMKM yang efektif?', 0, null, 'listItemStyle');
$sec->addListItem('Bagaimana implementasi sistem manajemen tiga level (customer, UMKM, admin)?', 0, null, 'listItemStyle');

$sec->addTitle('C. Tujuan', 3);
$sec->addListItem('Merancang website marketplace UMKM berbasis web yang interaktif dan responsif.', 0, null, 'listItemStyle');
$sec->addListItem('Mengimplementasikan katalog produk, keranjang, checkout, dan tracking pesanan.', 0, null, 'listItemStyle');
$sec->addListItem('Mengembangkan manajemen tiga level akses: customer, mitra UMKM, dan admin.', 0, null, 'listItemStyle');

$sec->addTitle('D. Manfaat', 3);
$sec->addListItem('UMKM: Platform digital untuk memasarkan produk online tanpa biaya besar.', 0, null, 'listItemStyle');
$sec->addListItem('Konsumen: Kemudahan menemukan dan membeli produk UMKM lokal berkualitas.', 0, null, 'listItemStyle');
$sec->addListItem('Pengembang: Pengalaman mengembangkan aplikasi web dengan Laravel.', 0, null, 'listItemStyle');

// ====== BAB II PEMBAHASAN ======
$sec->addPageBreak();
$sec = $phpWord->addSection($m);
$sec->addTitle('BAB II', 1);
$sec->addTitle('PEMBAHASAN', 1);
$sec->addTextBreak(1, null, 'normal');

$sec->addTitle('A. Gambaran Umum', 3);
addJ($sec, 'UMKM KITA adalah platform marketplace berbasis web yang menghubungkan UMKM dengan konsumen di Batam. Memiliki tiga role: Customer, Mitra UMKM, dan Admin.');

addImg($sec, $ssDir . 'about.png', 'Halaman About Us', 2);
addImg($sec, $ssDir . 'stores.png', 'Halaman Toko UMKM', 3);

$sec->addTitle('B. Arsitektur Sistem', 3);
addJ($sec, 'Dibangun dengan MVC. Model: 13 entitas (User, Store, Product, Category, Cart, CartItem, Order, OrderItem, Payment, Review, Testimonial, Wishlist, ContactMessage). Controller: Frontend, Admin, UMKM. View: Blade dengan 3 layout dan 50+ template. Middleware: AdminMiddleware dan UmkmMiddleware.');

$sec->addTitle('C. Fitur-Fitur Website', 3);

$sec->addTitle('1. Halaman Home', 3);
addJ($sec, 'Landing page dengan hero section, rekomendasi menu unggulan, section keunggulan, dan CTA WhatsApp untuk mitra UMKM.');

$sec->addTitle('2. Halaman Menu / Katalog Produk', 3);
addJ($sec, 'Menampilkan produk dengan pencarian, filter kategori, sorting harga, pagination, gambar, harga, diskon, dan status stok.');

addImg($sec, $ssDir . 'menu-katalog.png', 'Halaman Menu / Katalog Produk', 4);

$sec->addTitle('3. Halaman Detail Produk', 3);
addJ($sec, 'Informasi lengkap produk, gambar, harga diskon, stok, form pemesanan dengan catatan tambahan, dan tombol wishlist.');

$sec->addTitle('4. Halaman Toko UMKM', 3);
addJ($sec, 'Daftar toko dengan status buka/tutup otomatis, rating, estimasi waktu, minimum order. Dilengkapi filter area dan pencarian.');

$sec->addTitle('5. Halaman Login & Register', 3);
addJ($sec, 'Autentikasi dengan tampilan dua kolom. Fitur "Ingat Saya", "Lupa Password", dan reset password via email.');

addImg($sec, $ssDir . 'login.png', 'Halaman Login', 5);

$sec->addTitle('6. Halaman Tracking Pesanan', 3);
addJ($sec, 'Halaman publik untuk lacak status pesanan tanpa login. Masukkan nomor pesanan untuk lihat timeline dan rincian.');

addImg($sec, $ssDir . 'tracking.png', 'Halaman Tracking Pesanan', 6);

$sec->addTitle('7. Halaman Contact & FAQ', 3);
addJ($sec, 'Contact: Informasi alamat, WhatsApp, email, dan form pesan. FAQ: Pertanyaan umum dengan sistem accordion dan filter kategori.');

addImg($sec, $ssDir . 'contact.png', 'Halaman Contact', 7);
addImg($sec, $ssDir . 'faq.png', 'Halaman FAQ', 8);

$sec->addTitle('8. Panel Admin', 3);
addJ($sec, 'Dashboard dengan KPI Cards (Sales, Purchases, Paid, Profits), grafik Chart.js, produk terlaris, tabel inventaris. CRUD produk, kategori, pesanan, pengguna, review, dan laporan cetak.');

$sec->addTitle('9. Panel Mitra UMKM', 3);
addJ($sec, 'Mitra UMKM kelola toko (nama, jam operasional, area), produk (CRUD sendiri), dan proses pesanan masuk.');

// ====== BAB III PENUTUP ======
$sec->addPageBreak();
$sec = $phpWord->addSection($m);
$sec->addTitle('BAB III', 1);
$sec->addTitle('PENUTUP', 1);
$sec->addTextBreak(1, null, 'normal');

$sec->addTitle('A. Kesimpulan', 3);
$sec->addListItem('Website UMKM KITA berhasil dikembangkan dengan Laravel 12, PHP 8.2, MySQL, Tailwind CSS.', 0, null, 'listItemStyle');
$sec->addListItem('Platform menyediakan tiga level akses: customer, mitra UMKM, dan admin.', 0, null, 'listItemStyle');
$sec->addListItem('Fitur lengkap: katalog, keranjang, checkout, tracking, review, wishlist, multi-pembayaran.', 0, null, 'listItemStyle');
$sec->addListItem('Panel admin dengan dashboard grafik, CRUD, dan laporan.', 0, null, 'listItemStyle');
$sec->addListItem('Panel mitra UMKM untuk kemandirian kelola toko dan produk.', 0, null, 'listItemStyle');

$sec->addTitle('B. Saran', 3);
$sec->addListItem('Integrasi payment gateway Midtrans/Xendit untuk pembayaran real-time.', 0, null, 'listItemStyle');
$sec->addListItem('Notifikasi real-time WebSocket/Laravel Broadcasting.', 0, null, 'listItemStyle');
$sec->addListItem('Aplikasi mobile Flutter/React Native.', 0, null, 'listItemStyle');
$sec->addListItem('Integrasi ekspedisi untuk hitung ongkir otomatis.', 0, null, 'listItemStyle');
$sec->addListItem('Fitur chat customer-mitra & rekomendasi produk machine learning.', 0, null, 'listItemStyle');

// ====== DAFTAR PUSTAKA ======
$sec->addPageBreak();
$sec = $phpWord->addSection($m);
$sec->addTitle('DAFTAR PUSTAKA', 1);
$sec->addTextBreak(1, null, 'normal');

$refs = [
    '[1] Laravel Documentation. (2025). Laravel 12.x Documentation. https://laravel.com/docs/12.x',
    '[2] Tailwind CSS Documentation. (2025). Tailwind CSS v4. https://tailwindcss.com/docs',
    '[3] MySQL Documentation. (2025). MySQL 8.4 Reference Manual. https://dev.mysql.com/doc/',
    '[4] Otwell, T. (2011). Laravel: The PHP Framework for Web Artisans.',
    '[5] Robbins, J. (2023). Learning Web Design (6th ed.). O\'Reilly Media.',
    '[6] Stauffer, M. (2023). Laravel: Up & Running (3rd ed.). O\'Reilly Media.',
    '[7] Satzinger et al. (2020). Systems Analysis and Design (8th ed.). Cengage Learning.',
];
foreach ($refs as $r) {
    $sec->addText($r, ['name' => 'Times New Roman', 'size' => 12],
        ['alignment' => Jc::LEFT, 'lineHeight' => 1.5, 'indentation' => ['left' => 720, 'hanging' => 720]]);
}

// ====== SAVE ======
echo "Saving final document...\n";
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($outputPath);

echo "Makalah berhasil dibuat!\n";
echo "File: " . realpath($outputPath) . "\n";
echo "Ukuran: " . round(filesize($outputPath) / 1024, 2) . " KB\n";
echo "Screenshots termasuk: home, about, stores, menu, login, tracking, contact, faq\n";
