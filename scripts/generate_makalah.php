<?php
/**
 * Script untuk Generate Makalah UMKM KITA
 * 
 * Menghasilkan file .docx makalah lengkap tentang website UMKM KITA
 */

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;

// Create new PHPWord instance
$phpWord = new PhpWord();

// Set default font
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->setDefaultFontSize(12);

// Add styles
$phpWord->addTitleStyle(1, ['name' => 'Times New Roman', 'size' => 14, 'bold' => true], ['alignment' => Jc::CENTER, 'spaceAfter' => 200, 'spaceBefore' => 200]);
$phpWord->addTitleStyle(2, ['name' => 'Times New Roman', 'size' => 13, 'bold' => true], ['alignment' => Jc::LEFT, 'spaceAfter' => 150, 'spaceBefore' => 150]);
$phpWord->addTitleStyle(3, ['name' => 'Times New Roman', 'size' => 12, 'bold' => true, 'italic' => true], ['alignment' => Jc::LEFT, 'spaceAfter' => 100, 'spaceBefore' => 100]);

$phpWord->addParagraphStyle('justify', [
    'alignment' => Jc::BOTH,
    'spaceAfter' => 100,
    'lineHeight' => 1.5,
    'indentation' => ['firstLine' => 720]
]);

$phpWord->addParagraphStyle('center', [
    'alignment' => Jc::CENTER,
    'spaceAfter' => 100,
    'lineHeight' => 1.5
]);

$phpWord->addParagraphStyle('normal', [
    'alignment' => Jc::LEFT,
    'spaceAfter' => 100,
    'lineHeight' => 1.5
]);

$phpWord->addParagraphStyle('normalIndent', [
    'alignment' => Jc::BOTH,
    'spaceAfter' => 100,
    'lineHeight' => 1.5,
    'indentation' => ['firstLine' => 720]
]);

$phpWord->addParagraphStyle('listItem', [
    'alignment' => Jc::BOTH,
    'spaceAfter' => 60,
    'lineHeight' => 1.5,
    'indentation' => ['left' => 720]
]);

$phpWord->addParagraphStyle('listItem2', [
    'alignment' => Jc::BOTH,
    'spaceAfter' => 60,
    'lineHeight' => 1.5,
    'indentation' => ['left' => 1440]
]);

// Helper function to add a paragraph
function addP($section, $text, $style = 'normal', $fontSize = 12, $bold = false) {
    $section->addText($text, ['name' => 'Times New Roman', 'size' => $fontSize, 'bold' => $bold], $style);
}

function addBullet($section, $text, $level = 0, $bold = false) {
    $section->addListItem($text, $level, ['name' => 'Times New Roman', 'size' => 12, 'bold' => $bold], 'justify');
}

function addSection($section, $title, $level = 2) {
    $section->addTitle($title, $level);
}

// ================================================================
// SECTION 1: COVER / HALAMAN JUDUL
// ================================================================
$cover = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

// Add some spacing before title
for ($i = 0; $i < 6; $i++) {
    $cover->addTextBreak(1, null, 'center');
}

addP($cover, 'MAKALAH', 'center', 14, true);
$cover->addTextBreak(1, null, 'center');
addP($cover, 'WEBSITE MARKETPLACE UMKM BERBASIS WEB', 'center', 16, true);
addP($cover, '"UMKM KITA"', 'center', 16, true);
$cover->addTextBreak(2, null, 'center');
addP($cover, 'Disusun Untuk Memenuhi Tugas Mata Kuliah', 'center', 12, false);
addP($cover, 'Pengembangan Aplikasi Web', 'center', 12, false);
$cover->addTextBreak(3, null, 'center');
addP($cover, 'Disusun Oleh:', 'center', 12, false);
addP($cover, '[Nama Mahasiswa]', 'center', 12, true);
addP($cover, 'NIM. [Nomor Induk Mahasiswa]', 'center', 12, false);
$cover->addTextBreak(2, null, 'center');
addP($cover, 'PROGRAM STUDI [Program Studi]', 'center', 12, true);
addP($cover, 'FAKULTAS [Nama Fakultas]', 'center', 12, true);
addP($cover, 'UNIVERSITAS [Nama Universitas]', 'center', 12, true);
addP($cover, 'TAHUN 2026', 'center', 12, true);

// ================================================================
// SECTION 2: KATA PENGANTAR
// ================================================================
$cover->addPageBreak();
$pengantar = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

addP($pengantar, 'KATA PENGANTAR', 'center', 14, true);
$pengantar->addTextBreak(1, null, 'center');

addP($pengantar, 'Puji syukur kehadirat Allah SWT / Tuhan Yang Maha Esa atas segala rahmat dan karunia-Nya sehingga penulis dapat menyelesaikan makalah yang berjudul "Website Marketplace UMKM Berbasis Web: UMKM KITA" ini dengan baik.', 'normalIndent');
$pengantar->addTextBreak(1, null, 'normal');
addP($pengantar, 'Makalah ini disusun untuk memenuhi tugas mata kuliah Pengembangan Aplikasi Web serta untuk memberikan gambaran mengenai pengembangan platform marketplace digital bagi Usaha Mikro, Kecil, dan Menengah (UMKM) di Indonesia, khususnya di area Batam.', 'normalIndent');
$pengantar->addTextBreak(1, null, 'normal');
addP($pengantar, 'Penulis menyadari bahwa makalah ini masih jauh dari sempurna. Oleh karena itu, kritik dan saran yang membangun sangat penulis harapkan untuk perbaikan di masa mendatang. Semoga makalah ini dapat memberikan manfaat bagi para pembaca dan seluruh pihak yang berkepentingan.', 'normalIndent');
$pengantar->addTextBreak(2, null, 'normal');

addP($pengantar, 'Batam, Juli 2026', 'normal', 12, false);
$pengantar->addTextBreak(2, null, 'normal');
addP($pengantar, 'Penulis', 'center', 12, false);

// ================================================================
// SECTION 3: DAFTAR ISI
// ================================================================
$pengantar->addPageBreak();
$daftarIsi = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

addP($daftarIsi, 'DAFTAR ISI', 'center', 14, true);
$daftarIsi->addTextBreak(1, null, 'center');

$tocItems = [
    'HALAMAN JUDUL' => 'i',
    'KATA PENGANTAR' => 'ii',
    'DAFTAR ISI' => 'iii',
    'BAB I   PENDAHULUAN' => '1',
    '    A. Latar Belakang' => '1',
    '    B. Rumusan Masalah' => '2',
    '    C. Tujuan Penulisan' => '2',
    '    D. Manfaat Penulisan' => '2',
    'BAB II  LANDASAN TEORI' => '3',
    '    A. Laravel Framework' => '3',
    '    B. Tailwind CSS' => '3',
    '    C. MySQL Database' => '4',
    '    D. Konsep Marketplace UMKM' => '4',
    'BAB III PEMBAHASAN' => '5',
    '    A. Gambaran Umum Website' => '5',
    '    B. Struktur Website' => '5',
    '    C. Fitur-Fitur Website' => '6',
    '        1. Halaman Home' => '6',
    '        2. Halaman Menu / Katalog Produk' => '6',
    '        3. Halaman Detail Produk' => '7',
    '        4. Halaman Toko UMKM' => '7',
    '        5. Halaman Keranjang Belanja' => '8',
    '        6. Halaman Checkout' => '8',
    '        7. Halaman Pesanan' => '9',
    '        8. Halaman Tracking Pesanan' => '9',
    '        9. Halaman Testimoni & Review' => '10',
    '        10. Halaman Wishlist' => '10',
    '        11. Halaman Akun Saya' => '11',
    '        12. Halaman About Us' => '11',
    '        13. Halaman Contact' => '12',
    '        14. Halaman FAQ' => '12',
    '        15. Halaman Terms & Conditions' => '12',
    '        16. Halaman Auth (Login & Register)' => '13',
    '        17. Panel Admin' => '13',
    '        18. Panel UMKM' => '14',
    '    D. Arsitektur Sistem' => '15',
    '    E. Entity Relationship Diagram' => '15',
    'BAB IV PENUTUP' => '16',
    '    A. Kesimpulan' => '16',
    '    B. Saran' => '16',
    'DAFTAR PUSTAKA' => '17',
];

foreach ($tocItems as $item => $page) {
    $bold = !str_starts_with($item, '    ');
    $daftarIsi->addText(
        $item . str_repeat('.', 60 - strlen($item)) . ' ' . $page,
        ['name' => 'Times New Roman', 'size' => 12, 'bold' => $bold],
        ['alignment' => Jc::LEFT, 'lineHeight' => 1.5]
    );
}

// ================================================================
// SECTION 4: BAB 1 - PENDAHULUAN
// ================================================================
$daftarIsi->addPageBreak();
$bab1 = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

addP($bab1, 'BAB I', 'center', 14, true);
addP($bab1, 'PENDAHULUAN', 'center', 14, true);
$bab1->addTextBreak(1);

addSection($bab1, 'A. Latar Belakang', 3);

addP($bab1, 'Perkembangan teknologi informasi dan internet telah membawa perubahan signifikan dalam berbagai aspek kehidupan, termasuk di sektor ekonomi dan bisnis. Di era digital ini, Usaha Mikro, Kecil, dan Menengah (UMKM) dituntut untuk dapat beradaptasi dengan perkembangan teknologi agar tetap kompetitif di pasar yang semakin luas. UMKM memiliki peran strategis dalam perekonomian Indonesia karena kontribusinya yang besar terhadap Produk Domestik Bruto (PDB) dan penyerapan tenaga kerja.', 'normalIndent');

addP($bab1, 'Namun, masih banyak pelaku UMKM yang mengalami kendala dalam memasarkan produk mereka secara digital. Keterbatasan sumber daya, pengetahuan teknologi, dan modal seringkali menjadi penghalang bagi UMKM untuk memiliki platform penjualan online yang profesional. Di sisi lain, konsumen juga kesulitan dalam menemukan dan mengakses produk-produk UMKM lokal yang berkualitas.', 'normalIndent');

addP($bab1, 'Berdasarkan permasalahan tersebut, penulis mengembangkan sebuah website marketplace berbasis web yang diberi nama "UMKM KITA". Website ini dirancang sebagai platform yang menghubungkan pelaku UMKM dengan konsumen secara langsung. UMKM KITA menyediakan berbagai fitur seperti katalog produk, sistem keranjang belanja, checkout, tracking pesanan, sistem review dan rating, serta panel khusus untuk admin dan mitra UMKM.', 'normalIndent');

addP($bab1, 'Dengan adanya platform ini, diharapkan para pelaku UMKM dapat lebih mudah memasarkan produk mereka secara online, sementara konsumen dapat dengan mudah menemukan dan membeli produk-produk UMKM lokal yang berkualitas. Website ini dibangun menggunakan framework Laravel 12 dengan bahasa pemrograman PHP 8.2 dan database MySQL, serta menggunakan Tailwind CSS untuk tampilan antarmuka yang modern dan responsif.', 'normalIndent');

$bab1->addTextBreak(1);
addSection($bab1, 'B. Rumusan Masalah', 3);

addP($bab1, 'Berdasarkan latar belakang yang telah diuraikan, rumusan masalah dalam penulisan makalah ini adalah sebagai berikut:', 'normalIndent');

addBullet($bab1, 'Bagaimana merancang dan membangun website marketplace UMKM berbasis web yang mudah digunakan?');
addBullet($bab1, 'Fitur-fitur apa saja yang diperlukan dalam platform marketplace UMKM yang efektif?');
addBullet($bab1, 'Bagaimana implementasi sistem manajemen pengguna (customer, mitra UMKM, dan admin) dalam satu platform?');
addBullet($bab1, 'Bagaimana mengintegrasikan sistem pemesanan, pembayaran, dan tracking pesanan dalam satu platform?');

$bab1->addTextBreak(1);
addSection($bab1, 'C. Tujuan Penulisan', 3);

addP($bab1, 'Tujuan dari penulisan makalah ini adalah sebagai berikut:', 'normalIndent');
addBullet($bab1, 'Merancang dan membangun website marketplace UMKM berbasis web yang interaktif dan responsif.');
addBullet($bab1, 'Mengimplementasikan fitur-fitur penting dalam platform marketplace seperti katalog produk, keranjang belanja, checkout, dan tracking pesanan.');
addBullet($bab1, 'Mengembangkan sistem manajemen pengguna dengan tiga level akses: customer, mitra UMKM, dan admin.');
addBullet($bab1, 'Mengintegrasikan sistem pemesanan dengan berbagai metode pembayaran termasuk transfer bank, QRIS, dan Cash on Delivery (COD).');

$bab1->addTextBreak(1);
addSection($bab1, 'D. Manfaat Penulisan', 3);

addP($bab1, 'Manfaat yang diharapkan dari penulisan makalah ini adalah:', 'normalIndent');
addBullet($bab1, 'Bagi Pelaku UMKM: Mendapatkan platform digital untuk memasarkan produk secara online tanpa biaya besar.');
addBullet($bab1, 'Bagi Konsumen: Memudahkan dalam menemukan dan membeli produk UMKM lokal berkualitas.');
addBullet($bab1, 'Bagi Pengembang: Menambah wawasan dan pengalaman dalam pengembangan aplikasi web menggunakan framework Laravel.');
addBullet($bab1, 'Bagi Akademisi: Memberikan referensi tentang pengembangan sistem marketplace UMKM berbasis web.');

// ================================================================
// SECTION 5: BAB 2 - LANDASAN TEORI
// ================================================================
$bab1->addPageBreak();
$bab2 = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

addP($bab2, 'BAB II', 'center', 14, true);
addP($bab2, 'LANDASAN TEORI', 'center', 14, true);
$bab2->addTextBreak(1);

addSection($bab2, 'A. Laravel Framework', 3);

addP($bab2, 'Laravel adalah framework aplikasi web berbasis PHP yang open-source dan dirancang untuk mengikuti pola arsitektur Model-View-Controller (MVC). Laravel pertama kali dirilis oleh Taylor Otwell pada tahun 2011 dan sejak saat itu telah menjadi salah satu framework PHP paling populer di dunia.', 'normalIndent');

addP($bab2, 'Beberapa fitur unggulan Laravel antara lain:', 'normalIndent');
addBullet($bab2, 'Eloquent ORM (Object-Relational Mapping) yang memudahkan interaksi dengan database.');
addBullet($bab2, 'Blade Templating Engine yang menyediakan sintaks yang bersih dan powerful untuk tampilan.');
addBullet($bab2, 'Routing system yang fleksibel dan ekspresif.');
addBullet($bab2, 'Middleware untuk memfilter HTTP request yang masuk.');
addBullet($bab2, 'Artisan CLI untuk otomatisasi tugas-tugas pengembangan.');
addBullet($bab2, 'Sistem autentikasi dan otorisasi yang terintegrasi.');

addP($bab2, 'Pada proyek UMKM KITA, Laravel versi 12 digunakan sebagai framework utama karena kemampuannya dalam menangani aplikasi web berskala besar dengan struktur kode yang rapi dan maintainable. Eloquent ORM digunakan untuk mengelola relasi database yang kompleks antar tabel seperti User, Product, Order, dan Store.', 'normalIndent');

$bab2->addTextBreak(1);
addSection($bab2, 'B. Tailwind CSS', 3);

addP($bab2, 'Tailwind CSS adalah framework CSS utility-first yang memungkinkan pengembang untuk membangun antarmuka pengguna dengan cepat menggunakan kelas-kelas utilitas yang telah ditentukan. Berbeda dengan framework CSS tradisional seperti Bootstrap yang menyediakan komponen siap pakai, Tailwind CSS memberikan fleksibilitas penuh dalam mendesain tampilan.', 'normalIndent');

addP($bab2, 'Kelebihan menggunakan Tailwind CSS antara lain:', 'normalIndent');
addBullet($bab2, 'Proses pengembangan yang lebih cepat dengan utility classes.');
addBullet($bab2, 'Ukuran file CSS yang lebih kecil setelah proses purging.');
addBullet($bab2, 'Konsistensi desain yang terjaga dengan design system yang terdefinisi.');
addBullet($bab2, 'Responsivitas yang mudah diimplementasikan.');

addP($bab2, 'Dalam proyek UMKM KITA, Tailwind CSS digunakan untuk menciptakan tampilan yang modern, responsif, dan konsisten dengan tema warna khas cokelat yang memberikan kesan hangat dan alami sesuai dengan branding UMKM.', 'normalIndent');

$bab2->addTextBreak(1);
addSection($bab2, 'C. MySQL Database', 3);

addP($bab2, 'MySQL adalah sistem manajemen basis data relasional (RDBMS) open-source yang menggunakan SQL (Structured Query Language) sebagai bahasa query-nya. MySQL dikenal dengan performa tinggi, keandalan, dan kemudahan penggunaannya.', 'normalIndent');

addP($bab2, 'Pada proyek UMKM KITA, MySQL digunakan sebagai database utama untuk menyimpan seluruh data aplikasi termasuk data pengguna, produk, pesanan, toko, dan konten lainnya. Struktur database dirancang dengan relasi yang efisien untuk mendukung fungsionalitas marketplace.', 'normalIndent');

$bab2->addTextBreak(1);
addSection($bab2, 'D. Konsep Marketplace UMKM', 3);

addP($bab2, 'Marketplace adalah platform online yang mempertemukan penjual dan pembeli dalam satu ekosistem digital. Berbeda dengan toko online konvensional, marketplace memungkinkan banyak penjual untuk bergabung dan menawarkan produk mereka di satu platform yang sama.', 'normalIndent');

addP($bab2, 'Konsep marketplace yang diimplementasikan dalam UMKM KITA adalah:', 'normalIndent');
addBullet($bab2, 'Multi-vendor: Memungkinkan banyak mitra UMKM bergabung dan menjual produk mereka.');
addBullet($bab2, 'Manajemen Terpusat: Admin dapat mengelola seluruh aspek platform dari satu panel kontrol.');
addBullet($bab2, 'Sistem Review: Konsumen dapat memberikan ulasan dan rating untuk produk yang dibeli.');
addBullet($bab2, 'Fitur Pemesanan: Sistem pemesanan yang terintegrasi dengan manajemen status pesanan.');
addBullet($bab2, 'Multi-metode Pembayaran: Mendukung berbagai metode pembayaran untuk kenyamanan konsumen.');

// ================================================================
// SECTION 6: BAB 3 - PEMBAHASAN
// ================================================================
$bab2->addPageBreak();
$bab3 = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

addP($bab3, 'BAB III', 'center', 14, true);
addP($bab3, 'PEMBAHASAN', 'center', 14, true);
$bab3->addTextBreak(1);

addSection($bab3, 'A. Gambaran Umum Website', 3);

addP($bab3, 'UMKM KITA adalah platform marketplace berbasis web yang dirancang untuk menghubungkan pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) dengan konsumen di area Batam dan sekitarnya. Website ini dibangun menggunakan framework Laravel 12 dengan PHP 8.2, database MySQL, dan Tailwind CSS untuk tampilan antarmuka.', 'normalIndent');

addP($bab3, 'Website ini memiliki tiga peran pengguna (role):', 'normalIndent');
addBullet($bab3, 'Customer: Pengguna biasa yang dapat melihat katalog produk, melakukan pemesanan, memberikan review, dan mengelola wishlist.');
addBullet($bab3, 'Mitra UMKM: Pelaku UMKM yang memiliki toko dan dapat mengelola produk serta pesanan mereka sendiri melalui panel khusus.');
addBullet($bab3, 'Admin: Pengelola platform yang memiliki akses penuh ke seluruh fitur termasuk manajemen produk, kategori, pesanan, laporan, dan pengguna.');

$bab3->addTextBreak(1);
addSection($bab3, 'B. Struktur Website', 3);

addP($bab3, 'Struktur website UMKM KITA terdiri dari halaman-halaman berikut yang dikelompokkan berdasarkan fungsinya:', 'normalIndent');

addP($bab3, 'Halaman Publik (Tanpa Login):', 'normal', 12, true);
addBullet($bab3, 'Home — Landing page utama');
addBullet($bab3, 'Menu — Katalog produk dengan filter kategori dan pencarian');
addBullet($bab3, 'Product Detail — Detail lengkap produk');
addBullet($bab3, 'Stores — Daftar toko UMKM');
addBullet($bab3, 'Store Detail — Detail toko dan produknya');
addBullet($bab3, 'About Us — Halaman tentang perusahaan');
addBullet($bab3, 'Contact — Halaman kontak dan formulir pesan');
addBullet($bab3, 'FAQ — Pertanyaan yang sering diajukan');
addBullet($bab3, 'Terms & Conditions — Syarat dan ketentuan');
addBullet($bab3, 'Tracking — Lacak status pesanan');
addBullet($bab3, 'Testimonials — Halaman testimoni pengguna');
addBullet($bab3, 'Login / Register — Halaman autentikasi');

$bab3->addTextBreak(1);
addP($bab3, 'Halaman Khusus (Harus Login):', 'normal', 12, true);
addBullet($bab3, 'Cart — Keranjang belanja');
addBullet($bab3, 'Checkout — Proses pemesanan');
addBullet($bab3, 'Orders — Riwayat pesanan');
addBullet($bab3, 'Order Detail — Detail pesanan');
addBullet($bab3, 'Account — Halaman akun dan profil');
addBullet($bab3, 'Wishlists — Produk favorit');
addBullet($bab3, 'Create Testimonial — Membuat testimoni');

$bab3->addTextBreak(1);
addP($bab3, 'Panel Admin (/admin/*):', 'normal', 12, true);
addBullet($bab3, 'Dashboard — Ringkasan performa toko');
addBullet($bab3, 'Products — Manajemen produk');
addBullet($bab3, 'Categories — Manajemen kategori');
addBullet($bab3, 'Orders — Manajemen pesanan');
addBullet($bab3, 'Users — Manajemen pengguna');
addBullet($bab3, 'Reviews — Manajemen ulasan');
addBullet($bab3, 'Reports — Laporan penjualan');
addBullet($bab3, 'Settings — Pengaturan platform');
addBullet($bab3, 'Contact Support — Pesan dari pengguna');

$bab3->addTextBreak(1);
addP($bab3, 'Panel Mitra UMKM (/umkm/*):', 'normal', 12, true);
addBullet($bab3, 'Dashboard — Ringkasan toko');
addBullet($bab3, 'Store — Manajemen toko');
addBullet($bab3, 'Products — Manajemen produk sendiri');
addBullet($bab3, 'Orders — Manajemen pesanan masuk');

$bab3->addTextBreak(1);
addSection($bab3, 'C. Fitur-Fitur Website', 3);

// Fitur 1: Home
addSection($bab3, '1. Halaman Home', 3);
addP($bab3, 'Halaman Home merupakan halaman utama website yang pertama kali dilihat oleh pengunjung. Halaman ini dirancang dengan tampilan yang menarik dan informatif untuk memberikan kesan pertama yang baik. Beberapa komponen utama pada halaman Home antara lain:', 'normalIndent');
addBullet($bab3, 'Hero Section dengan background gambar dan teks ajakan "Enjoy the perfect Taste!" yang memberikan kesan profesional.');
addBullet($bab3, 'Section Features yang menampilkan tiga gambar produk unggulan dalam lingkaran dengan efek hover.');
addBullet($bab3, 'Section "Why Choose Us?" yang menjelaskan nilai lebih dari UMKM KITA.');
addBullet($bab3, 'Rekomendasi Menu yang menampilkan produk unggulan secara acak dengan gambar, nama, harga, dan tombol "Lihat Detail Menu".');
addBullet($bab3, 'CTA Section "Punya Usaha UMKM?" dengan tombol WhatsApp untuk menghubungi admin.');
addBullet($bab3, 'Navigation Bar fixed dengan menu Home, Toko, Menu, About Us, Contact, Review User, dan Lacak Pesanan.');
addBullet($bab3, 'Footer dengan informasi kontak, navigasi, dan jam operasional.');

$bab3->addTextBreak(1);
// Fitur 2: Menu
addSection($bab3, '2. Halaman Menu / Katalog Produk', 3);
addP($bab3, 'Halaman Menu menampilkan seluruh produk kuliner yang tersedia di platform UMKM KITA. Halaman ini dilengkapi dengan berbagai fitur untuk memudahkan pengguna menemukan produk yang diinginkan:', 'normalIndent');
addBullet($bab3, 'Search Bar untuk mencari menu favorit berdasarkan nama produk.');
addBullet($bab3, 'Filter Kategori dalam bentuk tombol rounded yang memungkinkan pengguna memfilter produk berdasarkan kategori.');
addBullet($bab3, 'Sort Options untuk mengurutkan produk berdasarkan: terbaru, harga rendah ke tinggi, harga tinggi ke rendah, dan nama (A-Z).');
addBullet($bab3, 'Grid produk yang menampilkan gambar produk dalam lingkaran, nama, deskripsi, kategori, harga (dengan diskon jika ada), dan status stok.');
addBullet($bab3, 'Tombol "Lihat Detail & Pesan" untuk produk yang tersedia, atau indikator "Stok Habis" untuk produk yang tidak tersedia.');
addBullet($bab3, 'Pagination untuk membagi tampilan produk dalam beberapa halaman.');

$bab3->addTextBreak(1);
// Fitur 3: Product Detail
addSection($bab3, '3. Halaman Detail Produk', 3);
addP($bab3, 'Halaman Detail Produk menampilkan informasi lengkap tentang suatu produk. Halaman ini dapat diakses dengan mengklik salah satu produk dari halaman Menu atau halaman lainnya. Fitur-fitur yang tersedia:', 'normalIndent');
addBullet($bab3, 'Breadcrumb navigasi (Home / Menu / Nama Produk).');
addBullet($bab3, 'Gambar produk dalam ukuran besar dengan efek hover zoom.');
addBullet($bab3, 'Informasi produk: nama, kategori, pembuat (UMKM), dan alamat UMKM.');
addBullet($bab3, 'Harga produk dengan tampilan harga diskon, harga asli (coret), dan persentase diskon.');
addBullet($bab3, 'Status stok produk (Tersedia / Habis).');
addBullet($bab3, 'Form pemesanan dengan pemilih jumlah (+/-) dan input catatan tambahan (opsional).');
addBullet($bab3, 'Tombol "Tambahkan ke Keranjang" yang akan menyimpan produk ke keranjang belanja.');
addBullet($bab3, 'Tombol favorit (wishlist) untuk menyimpan produk ke daftar favorit.');
addBullet($bab3, 'Section Ulasan Pelanggan yang menampilkan rating rata-rata dan daftar ulasan dari pembeli sebelumnya.');
addBullet($bab3, 'Balasan admin pada setiap ulasan jika ada.');

$bab3->addTextBreak(1);
// Fitur 4: Toko
addSection($bab3, '4. Halaman Toko UMKM', 3);
addP($bab3, 'Halaman Toko UMKM menampilkan daftar toko yang terdaftar di platform. Halaman ini terdiri dari:', 'normalIndent');
addBullet($bab3, 'Halaman Daftar Toko (Stores Index): Menampilkan semua toko dalam bentuk kartu dengan informasi nama, area, status buka/tutup, rating, estimasi waktu, dan minimum order. Dilengkapi dengan fitur pencarian dan filter area.');
addBullet($bab3, 'Halaman Detail Toko (Store Show): Menampilkan informasi lengkap toko termasuk banner, nama, alamat, deskripsi, dan status buka/tutup. Informasi tambahan meliputi rating, estimasi pengiriman, minimum order, dan jam buka hari ini. Dilengkapi dengan tombol WhatsApp untuk menghubungi toko secara langsung.');
addBullet($bab3, 'Daftar produk dari toko tersebut dengan gambar, nama, dan harga.');
addBullet($bab3, 'Sistem pengecekan jam operasional otomatis: toko akan otomatis menampilkan status "Buka" atau "Tutup" berdasarkan jam operasional yang telah ditentukan.');

$bab3->addTextBreak(1);
// Fitur 5: Cart
addSection($bab3, '5. Halaman Keranjang Belanja', 3);
addP($bab3, 'Halaman Keranjang Belanja menampilkan semua produk yang telah ditambahkan oleh pengguna untuk dibeli. Fitur-fitur yang tersedia:', 'normalIndent');
addBullet($bab3, 'Daftar item keranjang dengan gambar produk, nama, harga satuan, dan subtotal.');
addBullet($bab3, 'Input jumlah (quantity) yang dapat diubah langsung oleh pengguna.');
addBullet($bab3, 'Tombol hapus untuk menghapus item dari keranjang.');
addBullet($bab3, 'Ringkasan Belanja yang menampilkan total item dan subtotal.');
addBullet($bab3, 'Tombol "Lanjut ke Pembayaran" yang mengarahkan ke halaman checkout.');
addBullet($bab3, 'Tampilan keranjang kosong dengan ajakan untuk mulai berbelanja.');

$bab3->addTextBreak(1);
// Fitur 6: Checkout
addSection($bab3, '6. Halaman Checkout', 3);
addP($bab3, 'Halaman Checkout adalah halaman untuk menyelesaikan proses pemesanan. Halaman ini berisi:', 'normalIndent');
addBullet($bab3, 'Form Data Pembeli: Nama lengkap dan nomor WhatsApp.');
addBullet($bab3, 'Metode Pengiriman: Pilihan antara "Kirim via Kurir" atau "Ambil Sendiri (Pick Up)".');
addBullet($bab3, 'Form Alamat Pengiriman yang muncul jika memilih kurir.');
addBullet($bab3, 'Jadwal Pesanan (opsional): Pengguna dapat memilih tanggal dan waktu pengiriman.');
addBullet($bab3, 'Metode Pembayaran: Transfer Bank, QRIS, atau Cash on Delivery (COD).');
addBullet($bab3, 'Ringkasan Pesanan: Menampilkan daftar produk, subtotal, pajak (10%), ongkos kirim, dan total pembayaran.');
addBullet($bab3, 'Logika dinamis: Jika memilih "Pick Up", ongkos kirim menjadi Rp 0 dan opsi COD dinonaktifkan.');

$bab3->addTextBreak(1);
// Fitur 7: Orders
addSection($bab3, '7. Halaman Pesanan', 3);
addP($bab3, 'Halaman Pesanan menampilkan riwayat pesanan yang telah dibuat oleh pengguna. Fitur-fitur yang tersedia:', 'normalIndent');
addBullet($bab3, 'Daftar pesanan dengan nomor pesanan, tanggal, jumlah item, total harga, status pesanan, dan status pembayaran.');
addBullet($bab3, 'Status pesanan ditampilkan dengan warna yang berbeda: amber (pending/menunggu), biru (diproses), hijau (selesai), dan merah (dibatalkan).');
addBullet($bab3, 'Informasi jadwal pengiriman jika ada.');
addBullet($bab3, 'Tombol untuk melihat detail pesanan.');

$bab3->addTextBreak(1);
addP($bab3, 'Halaman Detail Pesanan menampilkan informasi lengkap tentang suatu pesanan:', 'normalIndent');
addBullet($bab3, 'Timeline status pesanan: Pesanan Dibuat → Pembayaran → Diproses → Selesai.');
addBullet($bab3, 'Instruksi pembayaran yang berbeda untuk setiap metode pembayaran:');
addBullet($bab3, 'QRIS: Menampilkan kode QR (menggunakan library QRCode.js) dengan countdown timer 30 menit.', 1);
addBullet($bab3, 'Transfer: Menampilkan nomor rekening bank dan nominal transfer.', 1);
addBullet($bab3, 'COD: Menampilkan instruksi pembayaran tunai saat pengiriman.', 1);
addBullet($bab3, 'Rincian pesanan: daftar produk, subtotal, pajak, ongkos kirim, dan total akhir.');
addBullet($bab3, 'Informasi pengiriman: nomor telepon, alamat, dan jadwal pengiriman.');
addBullet($bab3, 'Tombol "Batalkan Pesanan" untuk pesanan dengan status pending atau processing.');

$bab3->addTextBreak(1);
// Fitur 8: Tracking
addSection($bab3, '8. Halaman Tracking Pesanan', 3);
addP($bab3, 'Halaman Tracking Pesanan adalah halaman publik yang memungkinkan siapa saja melacak status pesanan tanpa harus login. Cukup dengan memasukkan nomor pesanan, pengguna dapat melihat:', 'normalIndent');
addBullet($bab3, 'Informasi nomor pesanan dan status terkini dengan label warna.');
addBullet($bab3, 'Nama toko yang memproses pesanan.');
addBullet($bab3, 'Timeline lengkap status pesanan.');
addBullet($bab3, 'Rincian pesanan: produk, jumlah, subtotal, pajak, ongkir, dan total.');

$bab3->addTextBreak(1);
// Fitur 9: Testimoni & Review
addSection($bab3, '9. Halaman Testimoni & Review', 3);
addP($bab3, 'Halaman Testimoni menampilkan ulasan-ulasan dari pelanggan yang telah membeli produk. Fitur-fitur yang tersedia:', 'normalIndent');
addBullet($bab3, 'Grid testimoni dengan tampilan quotes yang menarik.');
addBullet($bab3, 'Rating bintang, komentar, nama pengguna, dan foto profil.');
addBullet($bab3, 'Informasi produk yang direview.');
addBullet($bab3, 'Pagination untuk testimoni yang banyak.');
addBullet($bab3, 'Form review langsung (tanpa login ke pesanan) bagi pengguna yang telah login.');
addBullet($bab3, 'Sistem star rating interaktif dengan efek hover dan pilihan rating 1-5.');

$bab3->addTextBreak(1);
addP($bab3, 'Selain itu, terdapat halaman khusus untuk membuat testimoni berdasarkan pesanan yang sudah selesai (Create Testimonial). Pengguna dapat memberikan rating dan komentar untuk produk yang telah dibeli melalui halaman detail pesanan.', 'normalIndent');

$bab3->addTextBreak(1);
// Fitur 10: Wishlist
addSection($bab3, '10. Halaman Wishlist', 3);
addP($bab3, 'Halaman Wishlist atau Favorit Saya menampilkan produk-produk yang telah disimpan oleh pengguna sebagai favorit. Fitur-fitur yang tersedia:', 'normalIndent');
addBullet($bab3, 'Grid produk favorit dengan gambar, nama, kategori, dan harga.');
addBullet($bab3, 'Tombol hati merah untuk menghapus produk dari wishlist.');
addBullet($bab3, 'Navigasi langsung ke halaman detail produk dengan mengklik kartu produk.');

$bab3->addTextBreak(1);
// Fitur 11: Account
addSection($bab3, '11. Halaman Akun Saya', 3);
addP($bab3, 'Halaman Akun Saya adalah pusat kendali pengguna untuk mengelola profil dan melihat aktivitas. Halaman ini terdiri dari:', 'normalIndent');
addBullet($bab3, 'Sidebar Profil: Foto profil (dapat diupload), nama, email, dan tombol upload avatar.');
addBullet($bab3, 'Ringkasan Pesanan: Total pesanan, jumlah selesai, dan jumlah diproses.');
addBullet($bab3, 'Informasi Profil: Form untuk mengubah nama, email, nomor telepon, dan alamat.');
addBullet($bab3, 'Ubah Password: Form untuk mengganti password dengan validasi password saat ini.');
addBullet($bab3, 'Pesanan Terbaru: Daftar 5 pesanan terakhir dengan status.');

$bab3->addTextBreak(1);
// Fitur 12: About
addSection($bab3, '12. Halaman About Us', 3);
addP($bab3, 'Halaman About Us menceritakan tentang latar belakang dan visi dari UMKM KITA. Halaman ini menampilkan:', 'normalIndent');
addBullet($bab3, 'Hero section dengan cerita "Cerita Di Balik Rasa".');
addBullet($bab3, 'Sejarah berdirinya UMKM KITA yang berawal dari dapur kecil keluarga.');
addBullet($bab3, 'Nilai-nilai perusahaan: Bahan Segar & Lokal, Resep Otentik, Higienis & Bersih.');
addBullet($bab3, 'Tim di balik UMKM KITA: Founder & CEO, Head Chef, dan Tech Lead.');

$bab3->addTextBreak(1);
// Fitur 13: Contact
addSection($bab3, '13. Halaman Contact', 3);
addP($bab3, 'Halaman Contact menyediakan informasi kontak dan formulir untuk menghubungi tim UMKM KITA:', 'normalIndent');
addBullet($bab3, 'Informasi kontak: alamat outlet di Iteba Tiban Ayu Batam, nomor WhatsApp, dan email.');
addBullet($bab3, 'Jam operasional (Senin - Minggu: 09.00 - 22.00 WIB).');
addBullet($bab3, 'Formulir kontak dengan input nama, email, subjek, dan pesan.');
addBullet($bab3, 'Data pesan dari formulir disimpan ke database tabel contact_messages untuk direspon oleh admin.');

$bab3->addTextBreak(1);
// Fitur 14: FAQ
addSection($bab3, '14. Halaman FAQ', 3);
addP($bab3, 'Halaman FAQ (Frequently Asked Questions) menyediakan jawaban atas pertanyaan-pertanyaan yang sering diajukan:', 'normalIndent');
addBullet($bab3, 'Filter kategori pertanyaan dengan tombol-tombol kategori.');
addBullet($bab3, 'Sistem accordion yang memungkinkan pengguna mengklik pertanyaan untuk melihat jawaban.');
addBullet($bab3, 'Animasi smooth untuk membuka dan menutup jawaban.');
addBullet($bab3, 'Tombol "Hubungi Kami" jika pengguna masih memiliki pertanyaan.');

$bab3->addTextBreak(1);
// Fitur 15: Terms
addSection($bab3, '15. Halaman Terms & Conditions', 3);
addP($bab3, 'Halaman Terms & Conditions berisi syarat dan ketentuan penggunaan platform UMKM KITA yang mencakup 10 pasal:', 'normalIndent');
addBullet($bab3, 'Penerimaan Syarat');
addBullet($bab3, 'Deskripsi Layanan');
addBullet($bab3, 'Akun Pengguna');
addBullet($bab3, 'Pemesanan & Pembayaran');
addBullet($bab3, 'Pengiriman');
addBullet($bab3, 'Pembatalan & Pengembalian');
addBullet($bab3, 'Ulasan & Konten Pengguna');
addBullet($bab3, 'Privasi');
addBullet($bab3, 'Batasan Tanggung Jawab');
addBullet($bab3, 'Perubahan Ketentuan');

$bab3->addTextBreak(1);
// Fitur 16: Auth
addSection($bab3, '16. Halaman Autentikasi (Login & Register)', 3);
addP($bab3, 'Halaman autentikasi menyediakan proses login dan registrasi pengguna:', 'normalIndent');

addP($bab3, 'Halaman Login:', 'normal', 12, true);
addBullet($bab3, 'Form login dengan input email dan password.');
addBullet($bab3, 'Tombol show/hide password.');
addBullet($bab3, 'Opsi "Ingat Saya" dan link "Lupa Password?".');
addBullet($bab3, 'Link untuk pengguna yang belum memiliki akun menuju halaman registrasi.');
addBullet($bab3, 'Tampilan dua kolom: kolom kiri dengan background food dan branding, kolom kanan dengan form login.');

addP($bab3, 'Halaman Register:', 'normal', 12, true);
addBullet($bab3, 'Form registrasi dengan input nama, email, no. HP/WA, alamat, password, dan konfirmasi password.');
addBullet($bab3, 'Validasi input di sisi server.');
addBullet($bab3, 'Link ke halaman login bagi yang sudah memiliki akun.');

addP($bab3, 'Halaman Forgot & Reset Password:', 'normal', 12, true);
addBullet($bab3, 'Form untuk meminta link reset password melalui email.');
addBullet($bab3, 'Halaman reset password dengan token validasi.');

$bab3->addTextBreak(1);
// Fitur 17: Admin Panel
addSection($bab3, '17. Panel Admin', 3);
addP($bab3, 'Panel Admin adalah halaman yang hanya dapat diakses oleh pengguna dengan role admin. Panel ini menyediakan berbagai fitur untuk mengelola seluruh aspek platform:', 'normalIndent');

addP($bab3, 'Dashboard Admin:', 'normal', 12, true);
addBullet($bab3, 'KPI Cards: Total Sales, Total Purchases, Total Paid, dan Profits dengan persentase tren (disertai indikator naik/turun).');
addBullet($bab3, 'Grafik Tren Penjualan (Chart.js) — Grafik garis penjualan bulanan.');
addBullet($bab3, 'Produk Terlaris — Diagram donat dan daftar produk dengan jumlah terjual dan persentase.');
addBullet($bab3, 'Manajemen Inventaris — Tabel produk dengan kolom ID, nama (dengan gambar), deskripsi, kategori, harga, stok, dan aksi (edit/hapus).');

addP($bab3, 'Manajemen Produk:', 'normal', 12, true);
addBullet($bab3, 'CRUD (Create, Read, Update, Delete) produk dengan validasi.');
addBullet($bab3, 'Upload gambar produk dan gallery.');
addBullet($bab3, 'Pengaturan harga, diskon, stok, dan status ketersediaan.');

addP($bab3, 'Manajemen Kategori:', 'normal', 12, true);
addBullet($bab3, 'CRUD kategori produk dengan upload gambar.');
addBullet($bab3, 'Pengaturan status aktif/non-aktif kategori.');

addP($bab3, 'Manajemen Pesanan:', 'normal', 12, true);
addBullet($bab3, 'Daftar semua pesanan dari seluruh pelanggan.');
addBullet($bab3, 'Update status pesanan dan status pembayaran.');
addBullet($bab3, 'Edit pesanan jika diperlukan.');

addP($bab3, 'Manajemen Pengguna:', 'normal', 12, true);
addBullet($bab3, 'Daftar semua pengguna terdaftar.');
addBullet($bab3, 'Edit dan hapus pengguna.');

addP($bab3, 'Manajemen Review:', 'normal', 12, true);
addBullet($bab3, 'Daftar semua ulasan dari pelanggan.');
addBullet($bab3, 'Approve atau tolak ulasan.');
addBullet($bab3, 'Balas ulasan dari admin.');

addP($bab3, 'Laporan:', 'normal', 12, true);
addBullet($bab3, 'Laporan penjualan harian dan bulanan.');
addBullet($bab3, 'Laporan stok produk.');
addBullet($bab3, 'Cetak laporan (print).');

addP($bab3, 'Lainnya:', 'normal', 12, true);
addBullet($bab3, 'Settings: Pengaturan platform.');
addBullet($bab3, 'Contact Support: Melihat pesan dari pengguna yang masuk melalui form kontak.');

$bab3->addTextBreak(1);
// Fitur 18: UMKM Panel
addSection($bab3, '18. Panel Mitra UMKM', 3);
addP($bab3, 'Panel Mitra UMKM adalah halaman khusus untuk pelaku UMKM yang telah terdaftar dan memiliki role umkm. Fitur-fitur yang tersedia:', 'normalIndent');

addBullet($bab3, 'Dashboard: Ringkasan toko mitra UMKM, termasuk jumlah produk, pesanan masuk, dan pendapatan.');
addBullet($bab3, 'Manajemen Toko: Mitra UMKM dapat mendaftarkan toko mereka dengan mengisi informasi seperti nama toko, deskripsi, alamat, area, nomor telepon, WhatsApp, jam operasional (per hari), estimasi waktu pengiriman, minimum order, dan upload gambar toko.');
addBullet($bab3, 'Manajemen Produk: CRUD produk milik sendiri. Mitra UMKM hanya dapat melihat dan mengelola produk mereka sendiri (bukan produk dari toko lain).');
addBullet($bab3, 'Manajemen Pesanan: Melihat daftar pesanan yang masuk ke toko mereka dan mengupdate status pesanan (diproses/selesai).');
addBullet($bab3, 'Sidebar navigasi dengan menu Dashboard, Toko Saya, Produk, dan Pesanan.');

$bab3->addTextBreak(1);
addSection($bab3, 'D. Arsitektur Sistem', 3);

addP($bab3, 'Website UMKM KITA dibangun menggunakan arsitektur Model-View-Controller (MVC) yang merupakan pola desain standar dalam framework Laravel. Berikut adalah penjelasan arsitektur sistem yang digunakan:', 'normalIndent');

addP($bab3, '1. Model (App\\Models):', 'normal', 12, true);
addBullet($bab3, 'User: Mengelola data pengguna dengan 3 role (customer, admin, umkm).');
addBullet($bab3, 'Store: Mengelola data toko UMKM.');
addBullet($bab3, 'Product: Mengelola data produk dengan relasi ke kategori, toko, dan review.');
addBullet($bab3, 'Category: Mengelola kategori produk.');
addBullet($bab3, 'Cart & CartItem: Mengelola keranjang belanja pengguna.');
addBullet($bab3, 'Order & OrderItem: Mengelola data pesanan.');
addBullet($bab3, 'Payment: Mengelola data pembayaran.');
addBullet($bab3, 'Review: Mengelola ulasan produk.');
addBullet($bab3, 'Testimonial: Mengelola testimoni pengguna.');
addBullet($bab3, 'Wishlist: Mengelola daftar favorit pengguna.');
addBullet($bab3, 'ContactMessage: Mengelola pesan dari form kontak.');

$bab3->addTextBreak(1);
addP($bab3, '2. Controller (App\\Http\\Controllers):', 'normal', 12, true);
addBullet($bab3, 'Frontend Controllers: Menangani logika halaman publik dan customer.');
addBullet($bab3, 'Admin Controllers: Menangani logika panel admin dengan middleware AdminMiddleware.');
addBullet($bab3, 'UMKM Controllers: Menangani logika panel mitra UMKM dengan middleware UmkmMiddleware.');

$bab3->addTextBreak(1);
addP($bab3, '3. View (resources/views):', 'normal', 12, true);
addBullet($bab3, 'Menggunakan Blade Templating Engine dari Laravel.');
addBullet($bab3, 'Tiga layout utama: app.blade.php (publik), admin.blade.php (admin), umkm.blade.php (mitra).');
addBullet($bab3, 'Komponen UI dengan Tailwind CSS untuk tampilan responsif.');

$bab3->addTextBreak(1);
addP($bab3, '4. Middleware:', 'normal', 12, true);
addBullet($bab3, 'AdminMiddleware: Memeriksa apakah user yang login memiliki role admin.');
addBullet($bab3, 'UmkmMiddleware: Memeriksa apakah user yang login memiliki role umkm.');
addBullet($bab3, 'Route grouping dengan middleware untuk membatasi akses halaman.');

$bab3->addTextBreak(1);
addSection($bab3, 'E. Entity Relationship Diagram', 3);

addP($bab3, 'Website UMKM KITA memiliki struktur database dengan relasi antar entitas sebagai berikut:', 'normalIndent');

addBullet($bab3, 'User memiliki relasi one-to-one dengan Cart dan Store.');
addBullet($bab3, 'User memiliki relasi one-to-many dengan Order, Testimonial, Review, dan Wishlist.');
addBullet($bab3, 'Store memiliki relasi one-to-many dengan Product dan Order.');
addBullet($bab3, 'Category memiliki relasi one-to-many dengan Product.');
addBullet($bab3, 'Product memiliki relasi one-to-many dengan CartItem, OrderItem, dan Review.');
addBullet($bab3, 'Cart memiliki relasi one-to-many dengan CartItem.');
addBullet($bab3, 'Order memiliki relasi one-to-many dengan OrderItem dan one-to-one dengan Payment dan Testimonial.');

addP($bab3, 'Seluruh migrasi database telah diimplementasikan menggunakan fitur Laravel Migration yang memungkinkan versi kontrol pada struktur database. Total terdapat lebih dari 20 file migrasi yang mengelola pembuatan dan modifikasi tabel-tabel database.', 'normalIndent');

// ================================================================
// SECTION 7: BAB 4 - PENUTUP
// ================================================================
$bab3->addPageBreak();
$bab4 = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

addP($bab4, 'BAB IV', 'center', 14, true);
addP($bab4, 'PENUTUP', 'center', 14, true);
$bab4->addTextBreak(1);

addSection($bab4, 'A. Kesimpulan', 3);

addP($bab4, 'Berdasarkan hasil pembahasan mengenai pengembangan website marketplace UMKM KITA, dapat disimpulkan beberapa hal sebagai berikut:', 'normalIndent');

addBullet($bab4, 'Website UMKM KITA berhasil dikembangkan menggunakan framework Laravel 12 dengan PHP 8.2 dan database MySQL, serta menggunakan Tailwind CSS untuk tampilan antarmuka yang modern dan responsif.');
addBullet($bab4, 'Platform ini menyediakan tiga level akses pengguna (customer, mitra UMKM, dan admin) yang masing-masing memiliki fitur dan hak akses yang sesuai dengan kebutuhan mereka.');
addBullet($bab4, 'Website ini dilengkapi dengan fitur-fitur lengkap marketplace seperti katalog produk dengan filter dan pencarian, keranjang belanja, sistem checkout, tracking pesanan, sistem review dan rating, wishlist, dan berbagai metode pembayaran (transfer, QRIS, dan COD).');
addBullet($bab4, 'Panel admin menyediakan dashboard dengan grafik dan KPI untuk memonitor performa platform, serta fitur CRUD untuk manajemen produk, kategori, pesanan, pengguna, dan laporan.');
addBullet($bab4, 'Panel mitra UMKM memungkinkan pelaku UMKM untuk mengelola toko dan produk mereka secara mandiri, serta memproses pesanan yang masuk.');
addBullet($bab4, 'Struktur database dirancang dengan relasi yang efisien untuk mendukung seluruh fungsionalitas marketplace.');

$bab4->addTextBreak(1);
addSection($bab4, 'B. Saran', 3);

addP($bab4, 'Untuk pengembangan lebih lanjut dari website UMKM KITA, penulis menyarankan beberapa hal sebagai berikut:', 'normalIndent');

addBullet($bab4, 'Integrasi dengan payment gateway pihak ketiga seperti Midtrans atau Xendit untuk memproses pembayaran secara real-time dan otomatis.');
addBullet($bab4, 'Penambahan fitur notifikasi real-time menggunakan WebSocket atau Laravel Broadcasting untuk memberi tahu pengguna tentang perubahan status pesanan.');
addBullet($bab4, 'Pengembangan aplikasi mobile (Android/iOS) menggunakan Flutter atau React Native agar platform dapat diakses lebih luas.');
addBullet($bab4, 'Integrasi dengan layanan ekspedisi/logistik untuk menghitung ongkos kirim secara otomatis dan real-time berdasarkan lokasi.');
addBullet($bab4, 'Penambahan fitur chat antara customer dan mitra UMKM untuk memudahkan komunikasi.');
addBullet($bab4, 'Implementasi sistem rekomendasi produk berbasis machine learning untuk memberikan rekomendasi yang lebih personal kepada pengguna.');
addBullet($bab4, 'Penambahan fitur multi-bahasa (Inggris, Mandarin, dll) untuk menjangkau pasar yang lebih luas mengingat Batam adalah kota internasional.');

// ================================================================
// SECTION 8: DAFTAR PUSTAKA
// ================================================================
$bab4->addPageBreak();
$pustaka = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(3),
    'marginRight' => Converter::cmToTwip(3),
]);

addP($pustaka, 'DAFTAR PUSTAKA', 'center', 14, true);
$pustaka->addTextBreak(1);

$references = [
    'Laravel Documentation. (2025). Laravel 12.x Documentation. https://laravel.com/docs/12.x',
    'Tailwind CSS Documentation. (2025). Tailwind CSS v4 Documentation. https://tailwindcss.com/docs',
    'MySQL Documentation. (2025). MySQL 8.4 Reference Manual. https://dev.mysql.com/doc/refman/8.4/en/',
    'PHP Documentation. (2025). PHP Manual. https://www.php.net/manual/en/',
    'Otwell, T. (2011). Laravel: The PHP Framework for Web Artisans. https://laravel.com/',
    'Robbins, J. (2023). Learning Web Design: A Beginner\'s Guide to HTML, CSS, JavaScript, and Web Graphics (6th ed.). O\'Reilly Media.',
    'Welling, L., & Thomson, L. (2016). PHP and MySQL Web Development (5th ed.). Addison-Wesley Professional.',
    'Stauffer, M. (2023). Laravel: Up & Running: A Framework for Building Modern PHP Apps (3rd ed.). O\'Reilly Media.',
    'McFarland, D. (2023). Tailwind CSS: A Practical Guide. Independently Published.',
    'Satzinger, J. W., Jackson, R. B., & Burd, S. D. (2020). Systems Analysis and Design in a Changing World (8th ed.). Cengage Learning.',
];

$counter = 1;
foreach ($references as $ref) {
    $pustaka->addText(
        '[' . $counter . '] ' . $ref,
        ['name' => 'Times New Roman', 'size' => 12],
        ['alignment' => Jc::LEFT, 'lineHeight' => 1.5, 'indentation' => ['left' => 720, 'hanging' => 720]]
    );
    $counter++;
}

// ================================================================
// SAVE THE DOCUMENT
// ================================================================
$filename = __DIR__ . '/../Makalah_UMKM_KITA.docx';

$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($filename);

echo "Makalah berhasil dibuat!\n";
echo "File: " . $filename . "\n";
echo "Ukuran: " . round(filesize($filename) / 1024, 2) . " KB\n";

?>