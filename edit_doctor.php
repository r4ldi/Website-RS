<?php
session_start();
include 'db.php';

$success = '';
$error = '';

if (!isset($_GET['id'])) {
    header("Location: dokter.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $specialty = trim($_POST['specialty']);
    $kelamin = trim($_POST['kelamin']);
    $phone = trim($_POST['phone']);
    $photo = $_FILES['photo']['name'];

    if ($photo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $error = "Gagal mengunggah foto.";
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE doctors SET name = ?, specialty = ?, kelamin = ?, phone = ?, photo = ? WHERE id = ?");
                $stmt->execute([$name, $specialty, $kelamin, $phone, $target_file, $id]);
                $success = "Data dokter berhasil diperbarui!";
            } catch (PDOException $e) {
                $error = "Terjadi kesalahan saat mengedit: " . $e->getMessage();
            }
        }
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE doctors SET name = ?, specialty = ?, kelamin = ?, phone = ? WHERE id = ?");
            $stmt->execute([$name, $specialty, $kelamin, $phone, $id]);
            $success = "Data dokter berhasil diperbarui!";
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan saat mengedit: " . $e->getMessage();
        }
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->execute([$id]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$doctor) {
        header("Location: dokter.php");
        exit;
    }
} catch (PDOException $e) {
    $error = "Terjadi kesalahan: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokter - Rumah Sakit</title>
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

    <!-- Form Edit Dokter -->
    <section class="py-12 text-center">
        <h2 class="text-2xl font-bold mb-6">Edit Data Dokter</h2>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <?php if ($success): ?>
                <div class="mb-4 text-green-500 font-semibold"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="mb-4 text-red-500 font-semibold"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form action="edit_doctor.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-left font-semibold">Nama</label>
                    <input type="text" id="name" name="name" class="w-full border border-black p-2" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="specialty" class="block text-left font-semibold">Spesialis</label>
                    <input type="text" id="specialty" name="specialty" class="w-full border border-black p-2" value="<?php echo htmlspecialchars($doctor['specialty']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="kelamin" class="block text-left font-semibold">Jenis Kelamin</label>
                    <div class="flex justify-around">
                        <label><input type="radio" name="kelamin" value="Laki-laki" <?php echo ($doctor['kelamin'] == 'Laki-laki') ? 'checked' : ''; ?> required> Laki-laki</label>
                        <label><input type="radio" name="kelamin" value="Perempuan" <?php echo ($doctor['kelamin'] == 'Perempuan') ? 'checked' : ''; ?> required> Perempuan</label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-left font-semibold">No Telp</label>
                    <input type="text" id="phone" name="phone" class="w-full border border-black p-2" value="<?php echo htmlspecialchars($doctor['phone']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="photo" class="block text-left font-semibold">Foto</label>
                    <input type="file" id="photo" name="photo" class="w-full border border-black p-2">
                </div>
                <button type="submit" class="w-full bg-dun border border-black text-black p-2 font-bold">Simpan</button>
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