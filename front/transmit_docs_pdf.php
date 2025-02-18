<?php 
// Include the TCPDF library
require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');  

// Retrieve input values from URL parameters
$for = $_GET['for'] ?? '';
$for_address = $_GET['for_address'] ?? '';
$attention = $_GET['attention'] ?? '';
$attention_address = $_GET['attention_address'] ?? '';
$from = $_GET['from'] ?? '';
$from_address = $_GET['from_address'] ?? '';
$subject = $_GET['subject'] ?? '';
$message = $_GET['message'] ?? ''; // Get message input

// Retrieve the selected month and year
$month = $_GET['month'] ?? '';
$year = $_GET['year'] ?? '';

// Fetch records filtered by the selected month and year
require_once(__DIR__ . '/db_connect.php');

// Format the month and year to match the date column format (e.g., '2025-02-15')
$startDate = $year . '-' . $month . '-01';  // First day of the month
$endDate = $year . '-' . $month . '-31';    // Last day of the month (to cover the full month)

$query = "SELECT project_name, particular, amount_remarks 
          FROM transmit_docs
          WHERE date BETWEEN '$startDate' AND '$endDate'";  // Filter by date range
$result = $conn->query($query);

// Create a custom TCPDF class to include a footer
class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('times', '', 7);
        $this->Cell(0, 5, 'Diversion Road, Brgy. Bantigue, Ormoc City, Leyte', 0, 1, 'C');
        $this->Cell(0, 5, '(Telefax No. (053) 560-3786) Email: cenroormoc17@yahoo.com', 0, 1, 'C');

        $this->SetXY(160, -30);
        $this->SetFont('helvetica', 'BU', 12);
        $this->Cell(0, 15, 'BALDOMERO U. NUÑEZ', 0, 1, 'R');
        $this->SetFont('helvetica', '', 12);
        $this->SetXY(160, -25);
        $this->Cell(0, 14, 'CENR Officer', 0, 1, 'L');
    }
}

$pdf = new MYPDF();
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('REPORT');
$pdf->SetSubject('Test PDF Creation');
$pdf->AddPage();

// Define image paths
$denrLogoPath = __DIR__ . '/../assets/img/sidebar-logo.png';
$bagongPilipinasPath = __DIR__ . '/../assets/img/bagong_pilipinas.png';
$logoSize = 25;

$pdf->Image($denrLogoPath, 20, 5, $logoSize, $logoSize, 'PNG');  
$pdf->Image($bagongPilipinasPath, 160, 5, $logoSize, $logoSize, 'PNG');  

$pdf->SetY(12.7);
$pdf->SetFont('times', '', 10);
$pdf->Cell(0, 4, 'Republic of the Philippines', 0, 1, 'C');
$pdf->Cell(0, 5, 'DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES', 0, 1, 'C');
$pdf->Cell(0, 5, 'KAGAWARAN NG KAPALIGIRAN AT LIKAS NA YAMAN', 0, 1, 'C');
$pdf->Cell(0, 5, 'Community Environment and Natural Resources Office - Ormoc', 0, 1, 'C');

$pdf->SetDrawColor(128, 0, 0);
$pdf->SetLineWidth(2);
$pdf->Line(0, 40, $pdf->GetPageWidth(), 40);
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 12);

// Display "FOR"
$pdf->Cell(40, 6, 'FOR     ', 0, 0, 'L');
$pdf->MultiCell(0, 20, ":                           $for\n                            $for_address", 0, 'L');

// Display "ATTENTION"
$pdf->Cell(40, 6, 'ATTENTION     ', 0, 0, 'L');
$pdf->MultiCell(0, 20, ":                           $attention\n                            $attention_address", 0, 'L');

// Display "FROM"
$pdf->Cell(40, 6, 'FROM     ', 0, 0, 'L');
$pdf->MultiCell(0, 4, ":                           $from\n   $from_address", 0, 'L');

// Display current Date
$currentDate = date("d-M-y");
$pdf->Cell(40, 10, 'DATE     ', 0, 0, 'L');
$pdf->Cell(0, 10, ":                           $currentDate", 0, 1, 'L');

// Display "SUBJECT"
$pdf->Cell(40, 10, 'SUBJECT     ', 0, 0, 'L');
$pdf->Cell(0, 10, ":                            $subject", 0, 1, 'L');

// Display selected Month and Year
// $pdf->Ln(5);  // Add some space before displaying month/year
// $pdf->Cell(40, 6, 'MONTH:     ', 0, 0, 'L');
// $pdf->Cell(0, 6, ":  " . date('F', mktime(0, 0, 0, $month, 10)) . " $year", 0, 1, 'L');

// Add black border above and below the message
$pdf->Ln(-2);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 10, $pdf->GetY()); // Top border
$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell(0, 10, $message, 0, 'L');
$pdf->Ln(3);
$pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 10, $pdf->GetY()); // Bottom border
$pdf->Ln(-7);

// Table for transmit_docs data filtered by selected month and year
$tableWidth = 20 + 50 + 50 + 60;  // Adjusted for numbering, project name, particular, and amount/remarks
$pageWidth = $pdf->GetPageWidth();
$startX = ($pageWidth - $tableWidth) / 2;
$pdf->SetX($startX);

$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 11);

// Table header with "No.", "Project Name", "Particular", and "Amount/Remarks"
$pdf->SetX($startX);
$pdf->Cell(20, 10, 'No.', 1, 0, 'C');
$pdf->Cell(50, 10, 'Project Name', 1, 0, 'C');
$pdf->Cell(50, 10, 'Particular', 1, 0, 'C');
$pdf->Cell(60, 10, 'Amount/Remarks', 1, 1, 'C');

// Table data with numbering
$pdf->SetFont('helvetica', '', 8);
$counter = 1;  // Initialize counter for "No."
while ($row = $result->fetch_assoc()) {
    $pdf->SetX($startX);
    $pdf->Cell(20, 10, $counter++, 1, 0, 'C');  // Display numbering
    $pdf->Cell(50, 10, $row['project_name'] ?? '', 1, 0, 'L');
    $pdf->Cell(50, 10, $row['particular'] ?? '', 1, 0, 'L');
    $pdf->Cell(60, 10, $row['amount_remarks'] ?? '', 1, 1, 'L');
}

$pdf->Output('transmittal_form.pdf', 'I');
?>
