<?php 
// Include the TCPDF library
require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');  

// Retrieve input values from URL parameters
$for = $_GET['for'] ?? '';
$for_address = $_GET['for_address'] ?? '';
$from = $_GET['from'] ?? '';
$from_address = $_GET['from_address'] ?? '';
$subject = $_GET['subject'] ?? '';
$message = $_GET['message'] ?? '';
$selectedMonth = $_GET['month'] ?? date('m'); 
$selectedYear = $_GET['year'] ?? date('Y');   

// Fetch records for the selected month and year from the database
require_once(__DIR__ . '/db_connect.php');
$query = "SELECT date_of_request, div_sec_unit_served, request_description, date_finished, rating 
          FROM transmittalform 
          WHERE YEAR(date_of_request) = ? AND MONTH(date_of_request) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $selectedYear, $selectedMonth);
$stmt->execute();
$result = $stmt->get_result();

// Custom TCPDF class for footer
class MYPDF extends TCPDF {
    public $lastPageFlag = false;

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('times', '', 7);
        $this->Cell(0, 5, 'Diversion Road, Brgy. Bantigue, Ormoc City, Leyte', 0, 1, 'C');
        $this->Cell(0, 5, '(Telefax No. (053) 560-3786) Email: cenroormoc17@yahoo.com', 0, 1, 'C');

        if ($this->lastPageFlag) {
            $this->SetXY(160, -35);
            $this->SetFont('helvetica', 'BU', 11);
            $this->Cell(0, 15, 'BALDOMERO U. NUÑEZ', 0, 1, 'R');
            $this->SetFont('helvetica', '', 12);
            $this->SetXY(160, -30);
            $this->Cell(0, 14, '  CENR Officer', 0, 1, 'L');
        }
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
$pdf->Cell(40, 6, 'FOR:     ', 0, 0, 'L');
$pdf->MultiCell(0, 20, ":   $for\n    $for_address", 0, 'L');

$pdf->Cell(40, 6, 'FROM:     ', 0, 0, 'L');
$pdf->MultiCell(0, 20, ":   $from\n    $from_address", 0, 'L');
$pdf->Cell(40, 10, 'SUBJECT:     ', 0, 0, 'L');
$pdf->Cell(0, 10, ":   $subject", 0, 1, 'L');

$currentDate = date("d-M-y");
$pdf->Cell(40, 10, 'DATE:     ', 0, 0, 'L');
$pdf->Cell(0, 10, ":   $currentDate", 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 10, $pdf->GetY()); 
$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell(0, 10, $message, 0, 'L');
$pdf->Ln(3);
$pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 10, $pdf->GetY()); 
$pdf->Ln(5);

// Table setup
$col1Width = 30; // DATE OF REQUEST
$col2Width = 30; // DIV/SEC/UNIT SERVED
$col3Width = 90; // REQUEST DESCRIPTION (longer width)
$col4Width = 30; // DATE FINISHED
$col5Width = 15; // RATING

$tableWidth = $col1Width + $col2Width + $col3Width + $col4Width + $col5Width;  // Total table width

$pageWidth = $pdf->GetPageWidth();  // Get the width of the page
$startX = ($pageWidth - $tableWidth) / 2;  // Calculate the X position to center the table
$pdf->SetX($startX);
$pdf->SetFont('helvetica', 'B', 9);

// Adjusted column widths and multi-line headers
$pdf->MultiCell($col1Width, 10, "DATE OF\nREQUEST", 1, 'C', 0, 0);
$pdf->MultiCell($col2Width, 10, "DIV/SEC/UNIT\nSERVED", 1, 'C', 0, 0);
$pdf->MultiCell($col3Width, 10, "REQUEST\nDESCRIPTION", 1, 'C', 0, 0); // Longer width for "Request Description"
$pdf->MultiCell($col4Width, 10, "DATE\nFINISHED", 1, 'C', 0, 0);
$pdf->MultiCell($col5Width, 10, "RATING", 1, 'C', 0, 1);

$pdf->SetFont('helvetica', '', 8);
$rowCount = 0;
$maxRowsPerPage = 10;
$firstPage = true;

while ($row = $result->fetch_assoc()) {
    // Calculate row height based on the number of lines required
    $dateLines = $pdf->getNumLines($row['date_of_request'] ?? '', $col1Width);
    $unitLines = $pdf->getNumLines($row['div_sec_unit_served'] ?? '', $col2Width);
    $descLines = $pdf->getNumLines($row['request_description'] ?? '', $col3Width);
    $finishedLines = $pdf->getNumLines($row['date_finished'] ?? '', $col4Width);
    $ratingLines = $pdf->getNumLines($row['rating'] ?? '', $col5Width);

    // The row height will be the maximum number of lines in any column
    $maxLines = max($dateLines, $unitLines, $descLines, $finishedLines, $ratingLines);
    $rowHeight = $maxLines * 6;  // Multiply by 6 to get the row height

    if ($rowCount == $maxRowsPerPage) {
        $pdf->AddPage();
        $pdf->SetX($startX);
        $pdf->SetFont('helvetica', '', 8);
        $rowCount = 0;
        $firstPage = false;
    }
    $pdf->SetX($startX);
    $pdf->MultiCell($col1Width, $rowHeight, $row['date_of_request'] ?? '', 1, 'L', 0, 0);
    $pdf->MultiCell($col2Width, $rowHeight, $row['div_sec_unit_served'] ?? '', 1, 'L', 0, 0);
    $pdf->MultiCell($col3Width, $rowHeight, $row['request_description'] ?? '', 1, 'L', 0, 0);
    $pdf->MultiCell($col4Width, $rowHeight, $row['date_finished'] ?? '', 1, 'L', 0, 0);
    $pdf->MultiCell($col5Width, $rowHeight, $row['rating'] ?? '', 1, 'C', 0, 1);
    $rowCount++;
}

$pdf->lastPageFlag = true;
$pdf->lastPage();
$pdf->Output('transmittal_form.pdf', 'I');
?>
