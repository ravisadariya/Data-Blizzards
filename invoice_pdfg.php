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

// Create a function to get product name by ID
function getProductName($productId, $conn)
{
    $sql = "SELECT name FROM Products WHERE product_id = $productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    } else {
        return 'Product Not Found';
    }
}


// Create a function to get customer name by ID
function getCustomerName($customerId, $conn)
{
    $sql = "SELECT name FROM Customers WHERE customer_id = $customerId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    } else {
        return 'Customer Not Found';
    }
}

if (isset($_GET['invoice_id'])) {
    // READ Operation
    $sql = "SELECT * FROM Invoices Where invoice_id =" . $_GET['invoice_id'];
    $result = $conn->query($sql);


    // Create new PDF
    $pdf = new PDF();
    $pdf->AddPage();

    // Set font for table headings
    $pdf->SetFont('Arial', 'B', 12);

    // Add table headings manually
    $pdf->Cell(30, 10, 'ID', 1);
    $pdf->Cell(40, 10, 'Invoice Date', 1);
    $pdf->Cell(40, 10, 'Total Amount', 1);
    $pdf->Cell(40, 10, 'Product Name', 1);
    $pdf->Cell(40, 10, 'Customers Name', 1);
    $pdf->Ln();

    // Set font for table data
    $pdf->SetFont('Arial', '', 12);

    // Fetch customer data and add rows to the table
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->Cell(30, 10, $row['invoice_id'], 1);
            $pdf->Cell(40, 10, $row['invoice_date'], 1);
            $pdf->Cell(40, 10, $row['total_amount'], 1);
            $pdf->Cell(40, 10, getProductName($row['Products_product_id'], $conn), 1);
            $pdf->Cell(40, 10, getCustomerName($row["Customers_customer_id"], $conn), 1);
            $pdf->Ln();
        }
    } else {
        $pdf->Cell(200, 10, 'No records found', 1);
    }

    // Output the PDF
    $pdf->Output('D', 'invoice_list.pdf');

    // Close the database connection
    $conn->close();
}
