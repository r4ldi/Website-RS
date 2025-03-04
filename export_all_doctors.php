<?php
require_once('tcpdf/tcpdf.php');
include 'db.php';

// Fetch all doctors
$stmt = $pdo->query("SELECT * FROM doctors");
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rumah Sakit Hermina');
$pdf->SetTitle('Data Semua Dokter');
$pdf->SetSubject('Data Diri Semua Dokter');
$pdf->SetKeywords('TCPDF, PDF, dokter, rumah sakit');

// Add a page
$pdf->AddPage();

// Set font and color
$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(33, 37, 41);

// Add a title
$pdf->Cell(0, 15, 'Data Semua Dokter', 0, 1, 'C');

// Set font
$pdf->SetFont('helvetica', '', 12);
$pdf->SetY(30);

// Create HTML content
$html = "
<style>
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th, .data-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    .data-table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #f2f2f2;
    }
</style>
<table class='data-table'>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Spesialis</th>
            <th>Email</th>
            <th>No Telp</th>
        </tr>
    </thead>
    <tbody>";

foreach ($doctors as $doctor) {
    $html .= "
    <tr>
        <td>{$doctor['name']}</td>
        <td>{$doctor['specialty']}</td>
        <td>{$doctor['email']}</td>
        <td>{$doctor['phone']}</td>
    </tr>";
}

$html .= "
    </tbody>
</table>";

// Write HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('data_semua_dokter.pdf', 'I');
?>