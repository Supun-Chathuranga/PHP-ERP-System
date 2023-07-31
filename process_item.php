<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "includes/db_config.php";

    // Sanitize and validate form data (implement form validation here)
    $itemCode = $_POST["item_code"];
    $itemName = $_POST["item_name"];
    $itemCategory = $_POST["item_category"];
    $itemSubcategory = $_POST["item_subcategory"];
    $quantity = $_POST["quantity"];
    $unitPrice = $_POST["unit_price"];

    // Perform server-side validation
    // Add your validation logic here...

    // Prepare and execute the SQL query to insert the item into the database
    $sql = "INSERT INTO item (item_code, item_name, item_category, item_subcategory, quantity, unit_price)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdd", $itemCode, $itemName, $itemCategory, $itemSubcategory, $quantity, $unitPrice);

    // Check if the item is successfully added to the database
    if ($stmt->execute()) {
        // Item added successfully, redirect back to add_item.php with success message
        header("Location: add_item.php?success=1");
        exit();
    } else {
        // Item adding failed, redirect back to add_item.php with error message
        header("Location: add_item.php?error=1");
        exit();
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
