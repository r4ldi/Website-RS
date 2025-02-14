<?php
include 'db.php'; // Pastikan koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $kelas = $_POST["kelas"];
    $email = $_POST["email"];

    // Upload foto
    $foto = $_FILES["foto"]["name"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto);
    
    // Pindahkan file yang diunggah ke folder uploads/
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

    try {
        // Query dengan PDO
        $query = "INSERT INTO anggota (nama, kelas, email, foto) VALUES (:nama, :kelas, :email, :foto)";
        $stmt = $pdo->prepare($query);
        
        // Bind parameter
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kelas', $kelas);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':foto', $target_file);

        // Eksekusi query
        $stmt->execute();

        echo "Pendaftaran berhasil!";
        header("Location: anggota.php"); // Redirect ke halaman anggota
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
