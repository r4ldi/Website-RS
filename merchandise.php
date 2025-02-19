<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Contoh daftar obat
$obat = [
    ["name" => "Paracetamol", "price" => 5000, "image" => "images/paracetamol.jpg"],
    ["name" => "Ibuprofen", "price" => 10000, "image" => "images/ibuprofen.jpg"],
    ["name" => "Amoxicillin", "price" => 15000, "image" => "images/amoxicillin.jpg"],
];

// Tambahkan ke keranjang belanja
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $obat_name = $_POST['obat_name'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$obat_name])) {
        $_SESSION['cart'][$obat_name]['quantity'] += $quantity;
    } else {
        foreach ($obat as $item) {
            if ($item['name'] == $obat_name) {
                $_SESSION['cart'][$obat_name] = [
                    "name" => $item['name'],
                    "price" => $item['price'],
                    "quantity" => $quantity,
                    "image" => $item['image']
                ];
                break;
            }
        }
    }
    header("Location: merchandise.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Beli Obat - Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-rose-600 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="flex items-center space-x-2">
                <span class="text-white text-2xl font-bold font-serif">Rumah Sakit</span>
            </a>
            <ul class="flex space-x-6 text-white">
                <li><a href="main.php" class="hover:text-gray-300">Home</a></li>
                <li><a href="dokter.php" class="hover:text-gray-300">Dokter</a></li>
                <li><a href="pasien.php" class="hover:text-gray-300">Pasien</a></li>
                <li><a href="event.php" class="hover:text-gray-300">Event</a></li>
                <li><a href="pendaftaran.php" class="hover:text-gray-300">Pendaftaran</a></li>
                <li><a href="dokumentasi.php" class="hover:text-gray-300">Dokumentasi</a></li>
                <li><a href="merchandise.php" class="hover:text-gray-300">Tempat Beli Obat</a></li>
                <li><a href="logout.php" class="hover:text-gray-300">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Daftar Obat -->
    <section class="py-12 text-center">
        <h2 class="text-3xl font-bold mb-6">Tempat Beli Obat</h2>
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($obat as $item): ?>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-semibold"><?php echo $item['name']; ?></h3>
                    <p class="text-lg font-bold">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                    <form action="merchandise.php" method="POST" class="mt-4">
                        <input type="hidden" name="obat_name" value="<?php echo $item['name']; ?>">
                        <label for="quantity" class="block text-left font-semibold">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-full border border-black p-2 mb-4" required>
                        <button type="submit" name="add_to_cart" class="w-full bg-gray-200 border border-black text-black p-2 font-bold">Tambah ke Keranjang</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Keranjang Belanja -->
    <aside class="fixed top-20 right-10 bg-gray-800 text-white p-4 rounded-lg w-64">
        <h3 class="font-bold text-xl mb-4">Keranjang</h3>
        <?php if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) : ?>
            <?php $total = 0; ?>
            <?php foreach ($_SESSION['cart'] as $item) : ?>
                <?php if (is_array($item) && isset($item['name'], $item['quantity'], $item['price'])) : ?>
                    <div class="flex justify-between items-center mb-2">
                        <span><?= htmlspecialchars($item['name']) ?> x<?= (int)$item['quantity'] ?></span>
                        <div>
                            <form method="POST" class="inline">
                                <input type="hidden" name="obat_name" value="<?= htmlspecialchars($item['name']) ?>">
                                <button type="submit" name="update_cart" value="-" class="bg-red-500 px-2 rounded">-</button>
                            </form>
                            <form method="POST" class="inline">
                                <input type="hidden" name="obat_name" value="<?= htmlspecialchars($item['name']) ?>">
                                <button type="submit" name="update_cart" value="+" class="bg-green-500 px-2 rounded">+</button>
                            </form>
                        </div>
                    </div>
                    <?php $total += (int)$item['quantity'] * (int)$item['price']; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <hr class="my-2">
            <p class="text-right font-bold">Total: Rp <?= number_format($total, 0, ',', '.') ?></p>
            <form method="POST" action="checkout.php">
                <button type="submit" class="bg-blue-500 mt-4 p-2 rounded text-white w-full">Check Out</button>
            </form>
        <?php else : ?>
            <p>Keranjang kosong</p>
        <?php endif; ?>
    </aside>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Rumah Sakit - Semua Hak Dilindungi.</p>
        </div>
    </footer>

</body>
</html>