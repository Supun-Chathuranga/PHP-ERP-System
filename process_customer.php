<?php
// process_customer.php
require_once "includes/db_config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data (implement form validation here)

    // Prepare and execute the SQL query to insert the customer data
    $sql = "INSERT INTO customers (title, first_name, last_name, contact_number, district)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssss",
        $_POST["title"],
        $_POST["first_name"],
        $_POST["last_name"],
        $_POST["contact_number"],
        $_POST["district"]
    );
    $stmt->execute();

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect to the customer list page or display a success message
    header("Location: customer_list.php");
    exit();
}
