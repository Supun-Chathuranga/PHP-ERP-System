<?php
require_once "includes/db_config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the customer ID from the URL parameter
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $customer_id = $_GET['id'];

        // Retrieve customer data from the database
        $sql = "SELECT * FROM customer WHERE id = $customer_id";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            // Fetch customer details
            $row = $result->fetch_assoc();
            $title = $_POST['title'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $contact_no = $_POST['contact_no'];
            $district = $_POST['district'];

            // Update customer in the database
            $update_sql = "UPDATE customer SET title = '$title', first_name = '$first_name', 
                           last_name = '$last_name', contact_no = '$contact_no', district = '$district' 
                           WHERE id = $customer_id";

            if ($conn->query($update_sql) === TRUE) {
                header("Location: customer_list.php?success=1");
                exit();
            } else {
                echo "Error updating customer: " . $conn->error;
            }
        } else {
            echo "Customer not found.";
            exit();
        }
    } else {
        echo "Invalid customer ID.";
        exit();
    }
} else {
    // Retrieve the customer ID from the URL parameter and fetch customer data
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $customer_id = $_GET['id'];

        // Retrieve customer data from the database
        $sql = "SELECT * FROM customer WHERE id = $customer_id";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            // Fetch customer details
            $row = $result->fetch_assoc();
            $title = $row["title"];
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $contact_no = $row["contact_no"];
            $district = $row["district"];
        } else {
            echo "Customer not found.";
            exit();
        }
    } else {
        echo "Invalid customer ID.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Customer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Update Customer</h2>
            <form name="customerForm" action="" method="POST">
                <label>Title:</label>
                <input type="text" name="title" value="<?php echo $title; ?>" required><br>
                <label>First Name:</label>
                <input type="text" name="first_name" value="<?php echo $first_name; ?>" required><br>
                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $last_name; ?>" required><br>
                <label>Contact Number:</label>
                <input type="text" name="contact_no" value="<?php echo $contact_no; ?>"><br>
                <label>District:</label>
                <select name="district" required>
                    <?php
                    // Retrieve district data from the database
                    $district_sql = "SELECT * FROM district";
                    $district_result = $conn->query($district_sql);

                    if ($district_result->num_rows > 0) {
                        while ($district_row = $district_result->fetch_assoc()) {
                            $district_name = $district_row["district"];
                            $selected = ($district_name === $district) ? "selected" : "";
                            echo "<option value='$district_name' $selected>$district_name</option>";
                        }
                    }
                    ?>
                </select><br>
                <input type="submit" name="update_customer" value="Update">
            </form>
        </div>
    </div>
</body>
</html>
