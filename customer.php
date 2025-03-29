<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<?php
include "db.php";

// CREATE Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    $name = $_POST["name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];

    $sql = "INSERT INTO Customers (name, phone_number, email) VALUES ('$name', '$phone_number', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// READ Operation
$sql = "SELECT * FROM Customers";
$result = $conn->query($sql);





$conn->close();
?>


<div class="mt-3  d-flex justify-content-center">
<a href="index.php" class="btn btn-primary m-1">Visit Home Page</a>
        <a href="customer.php" class="btn btn-primary m-1">Visit Customer Page</a>
        <a href="address.php" class="btn btn-success m-1">Visit Address Page</a>
        <a href="invoice.php" class="btn btn-info m-1">Visit Invoice Page</a>
        <a href="products.php" class="btn btn-info m-1">Visit Product Page</a>
    </div>


<div class="container mt-5">
    <h1>Customer  Details</h1>

    <!-- CREATE Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number:</label>
            <input type="text" class="form-control" name="phone_number" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary" name="create">Create</button>
    </form>

    <a href='customer_pdfg.php' class='mt-4 btn btn-success btn-sm'>Download PDF</a>

    <!-- READ Operation -->
    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['customer_id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['phone_number']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- UPDATE Modals -->
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='modal fade' id='updateModal{$row['customer_id']}' tabindex='-1' aria-labelledby='updateModalLabel{$row['customer_id']}' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='updateModalLabel{$row['customer_id']}'>Update Customer</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <form method='post' action='{$_SERVER["PHP_SELF"]}'>
                                    <input type='hidden' name='customer_id' value='{$row['customer_id']}'>
                                    <div class='mb-3'>
                                        <label for='new_name' class='form-label'>New Name:</label>
                                        <input type='text' class='form-control' name='new_name' required>
                                    </div>
                                    <button type='submit' class='btn btn-warning' name='update'>Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
        }
    }
    ?>
</div>




<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
