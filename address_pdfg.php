<?php
// Include the database connection file
include "db.php";

// Include the FPDF library
require('fpdf184/fpdf.php');

// Create PDF class
class PDF extends FPDF {
    // Page header
    function Header() {
        // Logo
        $this->Image('logo/pharmacy.png', 85, 10, 40);
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Data Blizzards Pharmacy', 0, 1, 'C');
        $this->Ln(10);

        $this->Cell(0, 10, 'Date: ' . date('F j, Y'), 0, 1, 'C');

        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        // Line above signature
        $this->Ln(20);
        $this->Line(150, $this->GetY() - 10, 200, $this->GetY() - 10);
        // Signature
        $this->Cell(0, 0, 'Signature', 0, 0, 'R');

        // Position at 1.5 cm from the bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'B', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
    }
}

// READ Operation
$sqlAddresses = "SELECT A.address_id, A.street, A.city, A.zip_code, C.name as customer_name 
                FROM Address A 
                INNER JOIN Customers C ON A.Customers_customer_id = C.customer_id";
$resultAddresses = $conn->query($sqlAddresses);

// Create new PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Set font for table headings
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(150, 180, 200);

// Add table headings manually
$pdf->Cell(20, 10, 'ID', 1, 0, 'L', true);
$pdf->Cell(50, 10, 'Street', 1, 0, 'L', true);
$pdf->Cell(40, 10, 'City', 1, 0, 'L', true);
$pdf->Cell(30, 10, 'ZIP Code', 1, 0, 'L', true);
$pdf->Cell(50, 10, 'Customer Name', 1, 1, 'L', true);

// Set font for table data
$pdf->SetFont('Arial', '', 12);

// Loop through the data and add rows to the table
foreach ($resultAddresses as $address) {
    $pdf->Cell(20, 10, $address['address_id'], 1, 0, 'L');
    $pdf->Cell(50, 10, $address['street'], 1, 0, 'L');
    $pdf->Cell(40, 10, $address['city'], 1, 0, 'L');
    $pdf->Cell(30, 10, $address['zip_code'], 1, 0, 'L');
    $pdf->Cell(50, 10, $address['customer_name'], 1, 1, 'L');
}

// Output the PDF
$pdf->Output('D', 'address_list.pdf');

// Close the database connection
$conn->close();
?>
