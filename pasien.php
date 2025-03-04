<?php
session_start();
include 'db.php'; // Pastikan koneksi database terhubung

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

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#patientTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "dom": '<"flex justify-between items-center mb-4"<"flex flex-col items-start"<"search-container"f><"entries-container mt-2"l>><"add-button">>rt<"bottom flex justify-between"ip>',
            });

            // Add button
            $("div.add-button").html('<a href="pendaftaran.php" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-lg">Tambah Pasien</a>');
        });

        function showDeletePopup(patientId) {
            const popup = document.getElementById('delete-popup');
            const deleteLink = document.getElementById('confirm-delete');
            deleteLink.href = 'pasien.php?delete=' + patientId;
            popup.classList.remove('hidden');
        }

        function hideDeletePopup() {
            document.getElementById('delete-popup').classList.add('hidden');
        }
    </script>

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
        .dataTables_filter {
            float: left !important;
            text-align: left !important;
        }
        .dataTables_length {
            float: left !important;
            text-align: left !important;
            margin-top: 1rem !important;
        }
    </style>
</head>
<body class="bg-magnolia">

    <!-- Navbar -->
    <nav class="bg-van-dyke p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php"><img src="Hermina.png" alt="Hermina" class="h-10"></a>
            <ul class="flex space-x-6 text-magnolia">
                <li><a href="main.php">Home</a></li>
                <li><a href="dokter.php">Dokter</a></li>
                <li><a href="pasien.php">Pasien</a></li>
                <li><a href="pendaftaran.php">Pendaftaran</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Daftar Pasien -->
    <div class="max-w-7xl mx-auto py-12">
        <h2 class="text-center text-2xl font-bold mb-6">Daftar Pasien</h2>
        <table id="patientTable" class="display w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-dun text-black">
                <tr>
                    <th class="p-3">Foto</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Alamat</th>
                    <th class="p-3">Pendidikan</th>
                    <th class="p-3">Agama</th>
                    <th class="p-3">Kelamin</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM patients");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr class='text-center border-b'>";
                        echo "<td class='p-3'><img src='{$row['photo']}' alt='{$row['name']}' class='w-16 h-16 object-cover rounded-full'></td>";
                        echo "<td class='p-3'>{$row['name']}</td>";
                        echo "<td class='p-3'>{$row['alamat']}</td>";
                        echo "<td class='p-3'>{$row['pendidikan']}</td>";
                        echo "<td class='p-3'>{$row['agama']}</td>";
                        echo "<td class='p-3'>{$row['kelamin']}</td>";
                        echo "<td class='p-3'>
                            <a href='edit_patient.php?id={$row['id']}'><img src='edit.png' alt='Edit' class='inline w-6 h-6'></a> |
                            <a href='#' onclick='showDeletePopup({$row['id']})'><img src='delete.png' alt='Delete' class='inline w-6 h-6'></a> |
                            <a href='generate_pdf.php?id={$row['id']}'><img src='pdf.png' alt='Export PDF' class='inline w-6 h-6'></a>
                        </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='7' class='text-center p-4 text-red-500'>Error: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

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