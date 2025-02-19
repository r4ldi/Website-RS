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
    $class = $_POST['class'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $kelamin = $_POST['kelamin'];
    $photo = $_FILES['photo']['name'];

    if ($photo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } else {
        $target_file = $patient['photo'];
    }

    try {
        $stmt = $pdo->prepare("UPDATE patients SET name = ?, class = ?, alamat = ?, agama = ?, kelamin = ?, photo = ? WHERE id = ?");
        $stmt->execute([$name, $class, $alamat, $agama, $kelamin, $target_file, $id]);
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
                <li><a href="merchandise.php">Obat</a></li>
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
                    <label for="class" class="block text-left font-semibold">Kelas</label>
                    <input type="text" id="class" name="class" value="<?= $patient['class'] ?>" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-left font-semibold">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="<?= $patient['alamat'] ?>" class="w-full border border-black p-2" required>
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
                <button type="submit" name="edit_patient" class="w-full bg-gray-200 border border-black text-black p-2 font-bold">Update</button>
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