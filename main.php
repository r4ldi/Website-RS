<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Ambil daftar pasien dari database
try {
    $stmt = $pdo->query("SELECT name FROM patients");
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Rumah Sakit dengan pelayanan terbaik">
    <title>Rumah Sakit - Pilih Pelayanan Anda Sekarang!</title>
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-96" style="background-image: url('images/hero-image.jpg');">
        <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <h1 class="text-5xl text-white font-extrabold text-center">Rumah Sakit Terbaik</h1>
        </div>
    </section>

    <!-- Konten Tambahan -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-semibold">Selamat Datang</h2>
            <p class="mt-4 text-gray-600">Di website resmi Rumah Sakit</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Rumah Sakit - Semua Hak Dilindungi.</p>
        </div>
    </footer>

</body>
</html>