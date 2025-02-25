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
    <style>
        :root {
            --magnolia: #f7f0f5ff;
            --dun: #decbb7ff;
            --battleship-gray: #8f857dff;
            --walnut-brown: #5c5552ff;
            --van-dyke: #433633ff;
        }
        .bg-magnolia {
            background-color: var(--magnolia);
        }
        .bg-dun {
            background-color: var(--dun);
        }
        .bg-battleship-gray {
            background-color: var(--battleship-gray);
        }
        .bg-walnut-brown {
            background-color: var(--walnut-brown);
        }
        .bg-van-dyke {
            background-color: var(--van-dyke);
        }
        .text-magnolia {
            color: var(--magnolia);
        }
        .text-dun {
            color: var(--dun);
        }
        .text-battleship-gray {
            color: var(--battleship-gray);
        }
        .text-walnut-brown {
            color: var(--walnut-brown);
        }
        .text-van-dyke {
            color: var (--van-dyke);
        }
    </style>
</head>
<body class="bg-magnolia">
 <!-- Navbar -->
 <nav class="bg-van-dyke p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="text-magnolia text-2xl font-bold font-serif">Hermina</a>
            <ul class="flex space-x-6 text-magnolia">
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

    
    <!-- Dokter Section -->
    <section class="flex flex-col items-center justify-center py-16 bg-white text-center">
        <h2 class="text-3xl font-bold">Dokter</h2>
        <img src="Raldi.jpg" alt="Dokter" class="w-40 h-40 rounded-full mt-4">
        <h3 class="text-2xl font-semibold mt-2">Dr. Raldi</h3>
        <p class="text-lg mt-2">Email: <span class="font-bold">raldisikma123@gmail.com</span></p>
        <p class="text-lg">Instagram: <span class="font-bold">@r4ldi</span></p>
        <p class="text-lg">No Telp: <span class="font-bold">08123293434</span></p>
    </section>

    <!-- Footer -->
    <footer class="bg-van-dyke text-magnolia py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Rumah Sakit - Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>