<?php
session_start();
include 'db.php'; // Memastikan koneksi database di-load

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-rose-600 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="text-white text-2xl font-bold font-serif">Rumah Sakit</a>
            <ul class="flex space-x-6 text-white">
                <li><a href="main.php">Home</a></li>
                <li><a href="dokter.php">Dokter</a></li>
                <li><a href="pasien.php">Pasien</a></li>
                <li><a href="event.php">Event</a></li>
                <li><a href="pendaftaran.php">Pendaftaran</a></li>
                <li><a href="dokumentasi.php">Dokumentasi</a></li>
                <li><a href="merchandise.php">Merchandise</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Daftar Anggota -->
    <section class="text-center py-12">
    <h2 class="text-2xl font-bold mb-6">Daftar Pasien</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-7xl mx-auto">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM patients");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='bg-gray-300 p-2 text-center rounded-lg shadow-md'>";
                echo "<img src='{$row['photo']}' alt='{$row['name']}' class='w-full h-32 object-cover mb-2 rounded-lg'>";
                echo "<h3 class='text-lg font-semibold'>{$row['name']}</h3>";
                echo "<p class='text-sm'>Kelas: {$row['class']}</p>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
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