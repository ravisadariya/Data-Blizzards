<?php
include 'db.php';
// SELECT Customers for Dropdown
$sqlCustomers = "SELECT customer_id, name FROM Customers";
$resultCustomers = $conn->query($sqlCustomers);

// Address Creation Form

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_address"])) {
    $street = $_POST["street"];
    $city = $_POST["city"];
    $zip_code = $_POST["zip_code"];
    $customer_id = $_POST["customer_id"];

    $sql = "INSERT INTO Address (street, city, zip_code, Customers_customer_id) 
            VALUES ('$street', '$city', '$zip_code', '$customer_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Address created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$sqlAddresses = "SELECT A.address_id, A.street, A.city, A.zip_code, C.name as customer_name 
                FROM Address A 
                INNER JOIN Customers C ON A.Customers_customer_id = C.customer_id";
$resultAddresses = $conn->query($sqlAddresses);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address</title>
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

    <h1>Customer Address</h1>

    <!-- Address Creation Form -->
    <form method="post">
        <div class="mb-3">
            <label for="street" class="form-label">Street:</label>
            <input type="text" class="form-control" name="street" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City:</label>
            <input type="text" class="form-control" name="city" required>
        </div>
        <div class="mb-3">
            <label for="zip_code" class="form-label">ZIP Code:</label>
            <input type="text" class="form-control" name="zip_code" required>
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
        <button type="submit" class="btn btn-primary" name="create_address">Create</button>
    </form>
    <a href='address_pdfg.php' class='btn mt-4 btn-success btn-sm'>Download PDF</a>
</div>



<div class="container mt-5">
    <h1>Address List</h1>

    <!-- Display Table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Address ID</th>
                <th scope="col">Street</th>
                <th scope="col">City</th>
                <th scope="col">ZIP Code</th>
                <th scope="col">Customer Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultAddresses->num_rows > 0) {
                while ($row = $resultAddresses->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row["address_id"] . "</th>";
                    echo "<td>" . $row["street"] . "</td>";
                    echo "<td>" . $row["city"] . "</td>";
                    echo "<td>" . $row["zip_code"] . "</td>";
                    echo "<td>" . $row["customer_name"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No addresses found</td></tr>";
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
