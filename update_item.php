<?php
require_once "includes/db_config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process the update item form data (implement form validation here)
    $id = $_POST["id"];
    $itemCode = $_POST["item_code"];
    $itemName = $_POST["item_name"];
    $itemCategory = $_POST["item_category"];
    $itemSubcategory = $_POST["item_subcategory"];
    $quantity = $_POST["quantity"];
    $unitPrice = $_POST["unit_price"];

    // Perform server-side validation and update the item in the database
    $sql = "UPDATE item SET item_code=?, item_name=?, item_category=?, item_subcategory=?, quantity=?, unit_price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssidi", $itemCode, $itemName, $itemCategory, $itemSubcategory, $quantity, $unitPrice, $id);
    
    if ($stmt->execute()) {
        // Item updated successfully, redirect back to item_list.php
        header("Location: item_list.php");
        exit();
    } else {
        // Handle update error
    }

    $stmt->close();
}

// Retrieve the item data to pre-fill the update form
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM item WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $itemData = $result->fetch_assoc();
    } else {
        // Handle item not found error
    }

    $stmt->close();
}
?>

<!-- The rest of the update_item.php page remains unchanged as in the previous response -->
