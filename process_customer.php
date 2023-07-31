<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "includes/db_config.php";

    // Sanitize and validate form data (implement form validation here)
    $title = $_POST["title"];
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $contactNo = $_POST["contact_no"];
    $districtId = $_POST["district"];

    // Prepare and execute the SQL query to insert the customer into the database
    $sql = "INSERT INTO customer (title, first_name, last_name, contact_no, district)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $firstName, $lastName, $contactNo, $districtId);

    // Check if the customer is successfully added to the database
    if ($stmt->execute()) {
        // Customer added successfully, redirect back to add_customer.php with success message
        header("Location: add_customer.php?success=1");
        exit();
    } else {
        // Customer adding failed, redirect back to add_customer.php with error message
        header("Location: add_customer.php?error=1");
        exit();
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
