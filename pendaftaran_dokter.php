<?php
session_start();
include 'db.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $specialty = trim($_POST['specialty']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $photo = $_FILES['photo']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $error = "Gagal mengunggah foto.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO doctors (name, specialty, email, phone, photo) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $specialty, $email, $phone, $target_file]);
            $success = "Dokter berhasil didaftarkan!";
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
    <title>Pendaftaran Dokter - Rumah Sakit</title>
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

    <!-- Form Pendaftaran Dokter -->
    <section class="py-12 text-center">
        <h2 class="text-2xl font-bold mb-6">Pendaftaran Dokter Baru</h2>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <?php if ($success): ?>
                <div class="mb-4 text-green-500 font-semibold"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="mb-4 text-red-500 font-semibold"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form action="pendaftaran_dokter.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-left font-semibold">Nama</label>
                    <input type="text" id="name" name="name" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="specialty" class="block text-left font-semibold">Spesialis</label>
                    <input type="text" id="specialty" name="specialty" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-left font-semibold">Email</label>
                    <input type="email" id="email" name="email" class="w-full border border-black p-2" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-left font-semibold">No Telp</label>
                    <input type="text" id="phone" name="phone" class="w-full border border-black p-2" required>
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