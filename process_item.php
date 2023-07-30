<?php
// process_item.php
require_once "includes/db_config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data (implement form validation here)

    // Prepare and execute the SQL query to insert the item data
    $sql = "INSERT INTO items (item_code, item_name, item_category, item_subcategory, quantity, unit_price)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssdd",
        $_POST["item_code"],
        $_POST["item_name"],
        $_POST["item_category"],
        $_POST["item_subcategory"],
        $_POST["quantity"],
        $_POST["unit_price"]
    );
    $stmt->execute();

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect to the item list page or display a success message
    header("Location: item_list.php");
    exit();
}
