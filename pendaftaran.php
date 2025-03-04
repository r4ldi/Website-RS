<?php
session_start();
include 'db.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $kelamin = $_POST['kelamin'];
    $pendidikan = $_POST['pendidikan'];
    $photo = $_FILES['photo']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $error = "Gagal mengunggah foto.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO patients (name, email,alamat, pendidikan, agama, kelamin, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $alamat, $pendidikan, $agama, $kelamin, $target_file]);
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
                    <label for="alamat" class="block text-left font-semibold">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="pendidikan" class="block text-left font-semibold">Pendidikan</label>
                    <select id="pendidikan" name="pendidikan" class="w-full border border-black p-2" required>
                        <option value="SD">SD/MI/Sederajat</option>
                        <option value="SMP">SMP/MTs/Sederajat</option>
                        <option value="SMA">SMA/MA/SMK/Sederajat</option>
                        <option value="Diploma">Diploma (D1, D2, D3)</option>
                        <option value="Sarjana">Sarjana (S1)</option>
                        <option value="Magister">Magister (S2)</option>
                        <option value="Doktor">Doktor (S3)</option>
                    </select>
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
                <button type="submit" class="w-full bg-dun border border-black text-black p-2 font-bold">Daftar</button>
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