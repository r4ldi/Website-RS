<?php
require_once('tcpdf/tcpdf.php');
include 'db.php';

if (!isset($_GET['id'])) {
    die("Error: ID tidak ditemukan.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->execute([$id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    die("Error: Pasien tidak ditemukan.");
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rumah Sakit Hermina');
$pdf->SetTitle('Data Pasien');
$pdf->SetSubject('Data Diri Pasien');
$pdf->SetKeywords('TCPDF, PDF, pasien, rumah sakit');

// Add a page
$pdf->AddPage();

// Set font and color
$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(33, 37, 41);

// Add a title
$pdf->Cell(0, 15, 'Data Diri Pasien', 0, 1, 'C');

// Add patient photo
if ($patient['photo']) {
    $photo_path = $patient['photo'];
    
    // Check if GD is available
    if (!extension_loaded('gd') && !function_exists('gd_info')) {
        die("Error: GD extension is not loaded.");
    }

    // Load the image using GD
    $image = imagecreatefromstring(file_get_contents($photo_path));
    if ($image !== false) {
        ob_start();
        imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean();
        $pdf->Image('@' . $image_data, 75, 45, 60, 0, 'PNG', '', '', false, 300, '', false, false, 1, false, false, false);
        imagedestroy($image);
    } else {
        die("Error: Could not load image.");
    }
}

// Set font
$pdf->SetFont('helvetica', '', 12);
$pdf->SetY(110);

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
    <tr>
        <th>Nama:</th>
        <td>{$patient['name']}</td>
    </tr>
    <tr>
        <th>Alamat:</th>
        <td>{$patient['alamat']}</td>
    </tr>
    <tr>
        <th>Pendidikan:</th>
        <td>{$patient['pendidikan']}</td>
    </tr>
    <tr>
        <th>Agama:</th>
        <td>{$patient['agama']}</td>
    </tr>
    <tr>
        <th>Jenis Kelamin:</th>
        <td>{$patient['kelamin']}</td>
    </tr>
    <tr>
        <th>Email:</th>
        <td>{$patient['email']}</td>
    </tr>
</table>
";

// Write HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('data_pasien.pdf', 'I');
?>