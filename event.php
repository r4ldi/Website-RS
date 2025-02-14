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
    <title>Event - Merdeka Basketball</title>
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

    <!-- Event Section -->
    <section class="text-center py-16">
        <h2 class="text-3xl font-bold mb-8">Event</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
            <?php
            $events = [
                ["title" => "3X3", "location" => "At SMAN 1 BANDUNG", "date" => "17 Februari 2025", "image" => "images/3x3.jpg"],
                ["title" => "NBA JR", "location" => "At GOR Padjajaran", "date" => "24 Mei 2025", "image" => "images/nbajr.jpg"],
                ["title" => "DBL", "location" => "At GOR Padjajaran", "date" => "9 April 2025", "image" => "images/dbl.jpg"]
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
            <p>&copy; 2024 Ralyz - Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
