<?php
require_once "includes/db_config.php";

// Check if the customer ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Delete the customer from the database
    $delete_sql = "DELETE FROM customer WHERE id = $customer_id";

    if ($conn->query($delete_sql) === TRUE) {
        header("Location: customer_list.php?success=1");
        exit();
    } else {
        echo "Error deleting customer: " . $conn->error;
        exit();
    }
} else {
    echo "Invalid customer ID.";
    exit();
}
?>
