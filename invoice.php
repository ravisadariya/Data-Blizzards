<?php
include "db.php";

// INSERT Operation for Invoice
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_invoice"])) {
    $invoice_date = $_POST["invoice_date"];
    $total_amount = $_POST["total_amount"];
    $product_id = $_POST["product_id"];
    $customer_id = $_POST["customer_id"];

    $sql = "INSERT INTO Invoices (invoice_date, total_amount, Products_product_id, Customers_customer_id) 
            VALUES ('$invoice_date', '$total_amount', '$product_id', '$customer_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Invoice created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// SELECT Products and Customers for Dropdowns
$sqlProducts = "SELECT product_id, name FROM Products";
$resultProducts = $conn->query($sqlProducts);

$sqlCustomers = "SELECT customer_id, name FROM Customers";
$resultCustomers = $conn->query($sqlCustomers);

$sqlInvoices = "SELECT * FROM Invoices";
$resultInvoices = $conn->query($sqlInvoices);

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>


<div class="mt-3  d-flex justify-content-center">
<a href="index.php" class="btn btn-primary m-1">Visit Home Page</a>
        <a href="customer.php" class="btn btn-primary m-1">Visit Customer Page</a>
        <a href="address.php" class="btn btn-success m-1">Visit Address Page</a>
        <a href="invoice.php" class="btn btn-info m-1">Visit Invoice Page</a>
        <a href="products.php" class="btn btn-info m-1">Visit Product Page</a>
    </div>

    <div class="container mt-5">
        <h1>Customer Invoice </h1>

        <!-- Invoice Creation Form -->
        <form method="post">
            <div class="mb-3">
                <label for="invoice_date" class="form-label">Invoice Date:</label>
                <input type="text" class="form-control" name="invoice_date" required>
            </div>
            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Amount:</label>
                <input type="text" class="form-control" name="total_amount" required>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Select Product:</label>
                <select class="form-select" name="product_id" required>
                    <?php
                    while ($row = $resultProducts->fetch_assoc()) {
                        echo "<option value='" . $row['product_id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="customer_id" class="form-label">Select Customer:</label>
                <select class="form-select" name="customer_id" required>
                    <?php
                    while ($row = $resultCustomers->fetch_assoc()) {
                        echo "<option value='" . $row['customer_id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="create_invoice">Create Invoice</button>
        </form>
    </div>
    

    <div class="container mt-5">
        <h1>Invoice List</h1>

        <!-- Display Table -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Invoice Date</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultInvoices->num_rows > 0) {
                    while ($row = $resultInvoices->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th scope='row'>" . $row["invoice_id"] . "</th>";
                        echo "<td>" . $row["invoice_date"] . "</td>";
                        echo "<td>" . $row["total_amount"] . "</td>";
                        echo "<td>" . getProductName($row["Products_product_id"], $conn) . "</td>";
                        echo "<td>" . getCustomerName($row["Customers_customer_id"], $conn) . "</td>";
                        echo "<td>
                        <a href='invoice_pdfg.php?invoice_id={$row['invoice_id']}' class='btn btn-success btn-sm'>Download PDF</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No invoices found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>