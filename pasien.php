<?php
session_start();
include 'db.php'; // Memastikan koneksi database di-load

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM patients WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: pasien.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien - Rumah Sakit</title>
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
            color: var(--van-dyke);
        }
    </style>
    <script>
        function showDeletePopup(patientId) {
            const popup = document.getElementById('delete-popup');
            const deleteLink = document.getElementById('confirm-delete');
            deleteLink.href = 'pasien.php?delete=' + patientId;
            popup.classList.remove('hidden');
        }

        function hideDeletePopup() {
            const popup = document.getElementById('delete-popup');
            popup.classList.add('hidden');
        }
    </script>
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

    <!-- Daftar Pasien -->
    <section class="text-center py-12">
        <h2 class="text-2xl font-bold mb-6">Daftar Pasien</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-7xl mx-auto">
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM patients");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='bg-dun p-2 text-center rounded-lg shadow-md'>";
                    echo "<img src='{$row['photo']}' alt='{$row['name']}' class='w-full h-32 object-cover mb-2 rounded-lg'>";
                    echo "<h3 class='text-lg font-semibold'>{$row['name']}</h3>";
                    echo "<p class='text-sm'>Alamat: {$row['alamat']}</p>";
                    echo "<p class='text-sm'>Agama: {$row['agama']}</p>";
                    echo "<p class='text-sm'>Kelamin: {$row['kelamin']}</p>";
                    echo "<p class='text-sm'>Pendidikan: {$row['pendidikan']}</p>";
                    echo "<a href='edit_patient.php?id={$row['id']}' class='text-blue-500 hover:underline'>Edit</a> | ";
                    echo "<a href='#' onclick='showDeletePopup({$row['id']})' class='text-red-500 hover:underline'>Delete</a>";
                    echo "</div>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </section>

    <!-- Delete Confirmation Popup -->
    <div id="delete-popup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-bold mb-4">Yakin ingin menghapus?</h2>
            <div class="flex justify-center space-x-4">
                <a id="confirm-delete" href="#" class="bg-dun text-black px-4 py-2 rounded-lg">Hapus</a>
                <button onclick="hideDeletePopup()" class="bg-gray-300 text-black px-4 py-2 rounded-lg">Batal</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-van-dyke text-magnolia py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Rumah Sakit - Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>