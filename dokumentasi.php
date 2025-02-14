<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi - Merdeka Basketball</title>
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

    <!-- Dokumentasi Section -->
    <section class="py-12 text-center">
        <h2 class="text-3xl font-bold mb-6">Dokumentasi</h2>
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Dokumentasi 1 -->
            <div class="bg-gray-300 p-6 rounded-lg shadow-md">
                <img src="images/dbl.jpg" alt="DBL 2023" class="w-full h-60 object-cover rounded-lg">
                <p class="font-bold text-lg mt-4">DBL - 18 Juni 2023 - At GOR Padjajaran</p>
            </div>
            <!-- Dokumentasi 2 -->
            <div class="bg-gray-300 p-6 rounded-lg shadow-md">
                <img src="images/3x3.jpg" alt="3x3 2024" class="w-full h-60 object-cover rounded-lg">
                <p class="font-bold text-lg mt-4">3x3 - 19 September 2024 - At SMK Merdeka Bandung</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 SMK Merdeka - Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
