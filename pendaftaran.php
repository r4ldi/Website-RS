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
    <title>Pendaftaran - Rumah Sakit</title>
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

    <!-- Formulir Pendaftaran -->
    <section class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-6">Pendaftaran</h2>
            <form action="proses_pendaftaran.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama" class="block text-left font-semibold">Nama</label>
                    <input type="text" id="nama" name="nama" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="kelas" class="block text-left font-semibold">Kelas</label>
                    <input type="text" id="kelas" name="kelas" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-left font-semibold">Email</label>
                    <input type="email" id="email" name="email" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="foto" class="block text-left font-semibold">Foto Anggota</label>
                    <input type="file" id="foto" name="foto" class="w-full border border-black p-2">
                </div>
                <button type="submit" class="w-full bg-gray-200 border border-black text-black p-2 font-bold">Daftar</button>
            </form>
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