<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: merchandise.php");
    exit;
}

$id = $_GET['id'];
try {
    $stmt = $pdo->prepare("DELETE FROM medicines WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "Obat berhasil dihapus!";
} catch (PDOException $e) {
    $_SESSION['error'] = "Terjadi kesalahan saat menghapus obat: " . $e->getMessage();
}

header("Location: merchandise.php");
exit;
?>