<?php
include "db.php";

// INSERT Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    $name = $_POST["name"];
    $manufacturer = $_POST["manufacturer"];
    $dosage_form = $_POST["dosage_form"];
    $unit_price = $_POST["unit_price"];
    $stock_quantity = $_POST["stock_quantity"];

    $sql = "INSERT INTO Products (name, manufacturer, dosage_form, unit_price, stock_quantity) VALUES ('$name', '$manufacturer', '$dosage_form', '$unit_price', '$stock_quantity')";

    if ($conn->query($sql) === TRUE) {
        echo "Record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Details</title>
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
        <h1>Insert Product</h1>

        <!-- INSERT Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="manufacturer" class="form-label">Manufacturer:</label>
                <input type="text" class="form-control" name="manufacturer" required>
            </div>
            <div class="mb-3">
                <label for="dosage_form" class="form-label">Dosage Form:</label>
                <input type="text" class="form-control" name="dosage_form" required>
            </div>
            <div class="mb-3">
                <label for="unit_price" class="form-label">Unit Price:</label>
                <input type="text" class="form-control" name="unit_price" required>
            </div>
            <div class="mb-3">
                <label for="stock_quantity" class="form-label">Stock Quantity:</label>
                <input type="text" class="form-control" name="stock_quantity" required>
            </div>
            <button type="submit" class="btn btn-primary" name="create">Create Product</button>

        </form>
        <a href='products_pdfg.php' class='mt-4 btn btn-success btn-sm'>Download PDF</a>

    </div>





    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Manufacturer</th>
                    <th scope="col">Dosage Form</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Stock Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th scope='row'>" . $row["product_id"] . "</th>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["manufacturer"] . "</td>";
                        echo "<td>" . $row["dosage_form"] . "</td>";
                        echo "<td>" . $row["unit_price"] . "</td>";
                        echo "<td>" . $row["stock_quantity"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>