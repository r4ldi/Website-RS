<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi session cart jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Menambah barang ke keranjang
if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Jika barang sudah ada, tambahkan quantity
    if (isset($_SESSION['cart'][$product_name])) {
        $_SESSION['cart'][$product_name]['quantity'] += 1;
    } else {
        // Jika barang belum ada, tambahkan ke keranjang
        $_SESSION['cart'][$product_name] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        ];
    }
}

// Mengupdate jumlah barang di keranjang
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_cart"]) && isset($_POST["product_name"])) {
        $product_name = $_POST["product_name"];

        if ($_POST["update_cart"] == "+") {
            $_SESSION["cart"][$product_name]['quantity'] += 1; // Tambah barang
        } elseif ($_POST["update_cart"] == "-") {
            if ($_SESSION["cart"][$product_name]['quantity'] > 1) {
                $_SESSION["cart"][$product_name]['quantity'] -= 1; // Kurangi jumlah jika lebih dari 1
            } else {
                unset($_SESSION["cart"][$product_name]); // Hapus dari keranjang jika 0
            }
        }
    }
}

// Menghapus semua barang di keranjang setelah checkout
if (isset($_POST['checkout'])) {
    $_SESSION['cart'] = [];
    header("Location: checkout.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchandise - Merdeka Basketball</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-rose-600 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="flex items-center space-x-2">
                <span class="text-white text-2xl font-bold font-serif">Merdeka Basketball</span>
            </a>
            <ul class="flex space-x-6 text-white">
                <li><a href="main.php" class="hover:text-gray-300">Home</a></li>
                <li><a href="coach.php" class="hover:text-gray-300">Coach</a></li>
                <li><a href="anggota.php" class="hover:text-gray-300">Anggota</a></li>
                <li><a href="event.php" class="hover:text-gray-300">Event</a></li>
                <li><a href="pendaftaran.php" class="hover:text-gray-300">Pendaftaran</a></li>
                <li><a href="dokumentasi.php" class="hover:text-gray-300">Dokumentasi</a></li>
                <li><a href="merchandise.php" class="hover:text-gray-300">Merchandise</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Merchandise Section -->
<section class="py-12 text-center">
    <h2 class="text-3xl font-bold mb-6">Merchandise</h2>
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $products = [
            ["name" => "Jersey Merdeka", "price" => 120000, "image" => "images/jersey.jpg"],
            ["name" => "Shorts Merdeka", "price" => 80000, "image" => "images/shorts.jpg"],
            ["name" => "Tumbler Merdeka", "price" => 100000, "image" => "images/tumblr.jpg"]
        ];

        foreach ($products as $product) {
            echo "
            <div class='bg-gray-300 p-6 rounded-lg shadow-md text-center'>
                <img src='{$product['image']}' alt='{$product['name']}' class='h-80 w-full object-cover mb-4 rounded-lg'>
                <h3 class='font-bold text-xl'>{$product['name']}</h3>
                <p class='text-gray-700'>Rp " . number_format($product['price'], 0, ',', '.') . "</p>
                <form method='POST'>
                    <input type='hidden' name='product_name' value='{$product['name']}'>
                    <input type='hidden' name='product_price' value='{$product['price']}'>
                    <button type='submit' name='add_to_cart' class='bg-rose-600 text-white px-4 py-2 mt-4 rounded-lg'>Beli</button>
                </form>
            </div>";
        }
        ?>
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
                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['name']) ?>">
                                <button type="submit" name="update_cart" value="-" class="bg-red-500 px-2 rounded">-</button>
                            </form>
                            <form method="POST" class="inline">
                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['name']) ?>">
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
        <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 SMK Merdeka - Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
