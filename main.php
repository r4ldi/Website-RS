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
    <style>
        :root {
            --cream: #f5fdc6ff;
            --dark-moss-green: #41521fff;
        }
        .bg-cream {
            background-color: var(--cream);
        }
        .bg-dark-moss-green {
            background-color: var(--dark-moss-green);
        }
        .text-dark-moss-green {
            color: var(--dark-moss-green);
        }
        .text-cream {
            color: var(--cream);
        }
    </style>
</head>
<body class="bg-cream">

  <!-- Navbar -->
  <nav class="bg-dark-moss-green p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="text-cream text-2xl font-bold font-serif">Hermina</a>
            <ul class="flex space-x-6 text-cream">
                <li><a href="main.php">Home</a></li>
                <li><a href="dokter.php">Dokter</a></li>
                <li><a href="pasien.php">Pasien</a></li>
                <li><a href="event.php">Event</a></li>
                <li><a href="pendaftaran.php">Pendaftaran</a></li>
                <li><a href="merchandise.php">Obat</a></li>
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
    <footer class="bg-dark-moss-green text-cream py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Rumah Sakit - Semua Hak Dilindungi.</p>
        </div>
    </footer>

</body>
</html>