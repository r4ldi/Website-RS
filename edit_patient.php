<?php
session_start();
include 'db.php'; // Memastikan koneksi database di-load

if (!isset($_GET['id'])) {
    header("Location: pasien.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->execute([$id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    header("Location: pasien.php");
    exit;
}

// Handle edit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_patient'])) {
    $name = $_POST['name'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $kelamin = $_POST['kelamin'];
    $pendidikan = $_POST['pendidikan'];
    $photo = $_FILES['photo']['name'];

    if ($photo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } else {
        $target_file = $patient['photo'];
    }

    try {
        $stmt = $pdo->prepare("UPDATE patients SET name = ?, alamat = ?, pendidikan = ?, agama = ?, kelamin = ?, photo = ? WHERE id = ?");
        $stmt->execute([$name, $alamat, $pendidikan, $agama, $kelamin, $target_file, $id]);
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
    <title>Edit Pasien - Rumah Sakit</title>
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
</head>
<body class="bg-magnolia">
    <!-- Navbar -->
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

    <!-- Edit Pasien Form -->
    <section class="py-12 text-center">
        <h2 class="text-2xl font-bold mb-6">Edit Pasien</h2>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <form action="edit_patient.php?id=<?= $patient['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-left font-semibold">Nama</label>
                    <input type="text" id="name" name="name" value="<?= $patient['name'] ?>" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-left font-semibold">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="<?= $patient['alamat'] ?>" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="pendidikan" class="block text-left font-semibold">Pendidikan</label>
                    <select id="pendidikan" name="pendidikan" class="w-full border border-black p-2" required>
                        <option value="SD" <?= $patient['pendidikan'] == 'SD' ? 'selected' : '' ?>>SD/MI/Sederajat</option>
                        <option value="SMP" <?= $patient['pendidikan'] == 'SMP' ? 'selected' : '' ?>>SMP/MTs/Sederajat</option>
                        <option value="SMA" <?= $patient['pendidikan'] == 'SMA' ? 'selected' : '' ?>>SMA/MA/SMK/Sederajat</option>
                        <option value="Diploma" <?= $patient['pendidikan'] == 'Diploma' ? 'selected' : '' ?>>Diploma (D1, D2, D3)</option>
                        <option value="Sarjana" <?= $patient['pendidikan'] == 'Sarjana' ? 'selected' : '' ?>>Sarjana (S1)</option>
                        <option value="Magister" <?= $patient['pendidikan'] == 'Magister' ? 'selected' : '' ?>>Magister (S2)</option>
                        <option value="Doktor" <?= $patient['pendidikan'] == 'Doktor' ? 'selected' : '' ?>>Doktor (S3)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="agama" class="block text-left font-semibold">Agama</label>
                    <select id="agama" name="agama" class="w-full border border-black p-2" required>
                        <option value="Islam" <?= $patient['agama'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                        <option value="Kristen" <?= $patient['agama'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                        <option value="Katolik" <?= $patient['agama'] == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                        <option value="Hindu" <?= $patient['agama'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                        <option value="Buddha" <?= $patient['agama'] == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                        <option value="Konghucu" <?= $patient['agama'] == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="kelamin" class="block text-left font-semibold">Jenis Kelamin</label>
                    <select id="kelamin" name="kelamin" class="w-full border border-black p-2" required>
                        <option value="Laki-laki" <?= $patient['kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $patient['kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="photo" class="block text-left font-semibold">Foto</label>
                    <input type="file" id="photo" name="photo" class="w-full border border-black p-2">
                </div>
                <button type="submit" name="edit_patient" class="w-full bg-dun border border-black text-black p-2 font-bold">Update</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-van-dyke text-magnolia py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Rumah Sakit - Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>