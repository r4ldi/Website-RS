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
    <title>Dokter - Rumah Sakit</title>
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
            <li><a href="logout.php" class="hover:text-gray-300">Logout</a></li>
        </ul>
    </div>
</nav>
    
    <!-- Dokter Section -->
    <section class="flex flex-col items-center justify-center py-16 bg-white text-center">
        <h2 class="text-3xl font-bold">Dokter</h2>
        <img src="dokter.jpg" alt="Dokter" class="w-40 h-40 rounded-full mt-4">
        <h3 class="text-2xl font-semibold mt-2">Dr. Raldi</h3>
        <p class="text-lg mt-2">Email: <span class="font-bold">raldisikma123@gmail.com</span></p>
        <p class="text-lg">Instagram: <span class="font-bold">@r4ldi</span></p>
        <p class="text-lg">No Telp: <span class="font-bold">08123293434</span></p>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Rumah Sakit - Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>