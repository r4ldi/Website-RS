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
    <title>Event - Rumah Sakit</title>
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

    <!-- Event Section -->
    <section class="text-center py-16">
        <h2 class="text-3xl font-bold mb-8">Event</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
            <?php
            $events = [
                ["title" => "Seminar Kesehatan", "location" => "Aula Rumah Sakit", "date" => "17 Februari 2025", "image" => "images/seminar.jpg"],
                ["title" => "Donor Darah", "location" => "Lobby Rumah Sakit", "date" => "24 Mei 2025", "image" => "images/donor.jpg"],
                ["title" => "Pemeriksaan Gratis", "location" => "Parkiran Rumah Sakit", "date" => "9 April 2025", "image" => "images/pemeriksaan.jpg"]
            ];
            foreach ($events as $event) {
                echo "<div class='bg-gray-300 p-4 text-center rounded-lg shadow-lg'>";
                echo "<img src='{$event['image']}' alt='{$event['title']}' class='w-full h-48 object-cover mb-4 rounded-lg'>";
                echo "<h3 class='text-xl font-bold'>{$event['title']}</h3>";
                echo "<p class='text-md'>{$event['location']}</p>";
                echo "<p class='text-sm font-semibold mt-2'>{$event['date']}</p>";
                echo "</div>";
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