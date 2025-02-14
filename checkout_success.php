<?php
session_start();
if (!isset($_SESSION['checkout_message'])) {
    header("Location: merchandise.php");
    exit;
}

$message = $_SESSION['checkout_message'];
unset($_SESSION['checkout_message']); // Hapus data setelah ditampilkan

$pdf_url = $message['pdf'];
$whatsapp_message = urlencode("Halo, saya telah melakukan pembelian. Berikut struk pembelian saya: ");
$whatsapp_link = "https://wa.me/{$message['phone']}?text=$whatsapp_message";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Sukses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10 text-center">
        <h2 class="text-2xl font-bold">Pesanan sudah dibuat!</h2>
        <p class="mt-4 text-lg">Silahkan hubungi nomor ini untuk membayar:</p>
        <p class="font-bold text-2xl mt-2"><?= $message['phone'] ?> (Raldi)</p>

        <div class="mt-6">
            <a href="<?= $pdf_url ?>" class="bg-blue-500 text-white p-3 rounded-lg font-bold">Download Struk</a>
        </div>

        <div class="mt-4">
            <a href="<?= $whatsapp_link ?>" class="bg-green-500 text-white p-3 rounded-lg font-bold">Kirim ke WhatsApp</a>
        </div>
    </div>
</body>
</html>
