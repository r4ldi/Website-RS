<?php
session_start();
include 'db.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $class = $_POST['class'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $kelamin = $_POST['kelamin'];
    $photo = $_FILES['photo']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $error = "Gagal mengunggah foto.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO patients (name, email, class, alamat, agama, kelamin, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $class, $alamat, $agama, $kelamin, $target_file]);
            $success = "Pasien berhasil didaftarkan!";
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan saat mendaftar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien - Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-rose-600 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="text-white text-2xl font-bold font-serif">Hermina</a>
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

    <!-- Form Pendaftaran Pasien -->
    <section class="py-12 text-center">
        <h2 class="text-2xl font-bold mb-6">Pendaftaran Pasien Baru</h2>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <?php if ($success): ?>
                <div class="mb-4 text-green-500 font-semibold"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="mb-4 text-red-500 font-semibold"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form action="pendaftaran.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-left font-semibold">Nama</label>
                    <input type="text" id="name" name="name" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-left font-semibold">Email</label>
                    <input type="email" id="email" name="email" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="class" class="block text-left font-semibold">Kelas</label>
                    <input type="text" id="class" name="class" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-left font-semibold">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="agama" class="block text-left font-semibold">Agama</label>
                    <select id="agama" name="agama" class="w-full border border-black p-2" required>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="kelamin" class="block text-left font-semibold">Jenis Kelamin</label>
                    <select id="kelamin" name="kelamin" class="w-full border border-black p-2" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="photo" class="block text-left font-semibold">Foto</label>
                    <input type="file" id="photo" name="photo" class="w-full border border-black p-2">
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