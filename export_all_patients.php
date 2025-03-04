<?php
require_once('tcpdf/tcpdf.php');
include 'db.php';

// Fetch all patients
$stmt = $pdo->query("SELECT * FROM patients");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buat dokumen PDF baru
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rumah Sakit Hermina');
$pdf->SetTitle('Data Semua Pasien');
$pdf->SetSubject('Data Diri Semua Pasien');
$pdf->SetKeywords('TCPDF, PDF, pasien, rumah sakit');

// Tambahkan halaman baru
$pdf->AddPage();

// Tambahkan judul
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Data Semua Pasien', 0, 1, 'C');
$pdf->Ln(4);

// Atur font header tabel
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(240, 240, 240);

// Lebar kolom
$columnWidths = [35, 25, 40, 25, 20, 20, 40];

// Header tabel
$headers = ['Nama', 'Tgl Lahir', 'Alamat', 'Pendidikan', 'Agama', 'Kelamin', 'Diagnosa'];
foreach ($headers as $index => $header) {
    $pdf->Cell($columnWidths[$index], 8, $header, 1, 0, 'C', 1);
}
$pdf->Ln();

// Set font untuk data
$pdf->SetFont('helvetica', '', 10);

// Loop data pasien
foreach ($patients as $patient) {
    // Cek apakah masih ada cukup ruang di halaman
    if ($pdf->GetY() > 260) { 
        $pdf->AddPage();
    }
    
    // Tampilkan data dengan MultiCell agar tidak terpotong
    $pdf->Cell($columnWidths[0], 8, $patient['name'], 1);
    $pdf->Cell($columnWidths[1], 8, $patient['tanggal_lahir'], 1);
    $pdf->MultiCell($columnWidths[2], 8, $patient['alamat'], 1, 'L', 0, 0);
    $pdf->Cell($columnWidths[3], 8, $patient['pendidikan'], 1);
    $pdf->Cell($columnWidths[4], 8, $patient['agama'], 1);
    $pdf->Cell($columnWidths[5], 8, $patient['kelamin'], 1);
    $pdf->MultiCell($columnWidths[6], 8, $patient['diagnosa'], 1, 'L', 0, 1);
}

// Outputkan PDF
$pdf->Output('data_semua_pasien.pdf', 'I');
?>
