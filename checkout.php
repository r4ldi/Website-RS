<?php
session_start();
require_once 'tcpdf/tcpdf.php';

if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu.");
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Keranjang belanja kosong.");
}

// Ambil nama pembeli dari session
$nama_pembeli = $_SESSION['fullname']; 

// Simulasi alamat toko
$alamat_toko = "Jl. Merdeka No. 17, Jakarta";
$no_telp_toko = "0812-3456-7890";

// Hitung total harga
$total_harga = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_harga += $item['quantity'] * $item['price'];
}

// **Generate PDF**
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Struk Pembelian');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();
$pdf->SetFont('courier', '', 12); // Gunakan font monospasi agar lebih mirip struk asli

// Isi PDF
$html = "
<pre>
--------------------------------------
          Merdeka Basketball
Alamat: $alamat_toko
No. Telepon: $no_telp_toko
--------------------------------------
Nama Pembeli: $nama_pembeli
--------------------------------------
Detail Pesanan
--------------------------------------
Produk        | Jumlah | Harga
--------------------------------------";

foreach ($_SESSION['cart'] as $item) {
    $nama_produk = str_pad($item['name'], 12);
    $jumlah = str_pad($item['quantity'], 6, ' ', STR_PAD_BOTH);
    $harga = "Rp " . number_format($item['price'] * $item['quantity'], 0, ',', '.');
    $html .= "\n$nama_produk | $jumlah | $harga";
}

$html .= "
--------------------------------------
Total Harga: Rp " . number_format($total_harga, 0, ',', '.') . "
--------------------------------------
Terima kasih telah berbelanja di Merdeka Basketball!
</pre>";

// Kosongkan keranjang setelah checkout
unset($_SESSION['cart']);

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('struk_pembelian.pdf', 'I'); // Tampilkan PDF
?>
