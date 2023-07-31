<?php
require_once "includes/db_config.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Delete the item from the database
    $sql = "DELETE FROM item WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Item deleted successfully, redirect back to item_list.php
        header("Location: item_list.php");
        exit();
    } else {
        // Handle delete error
    }

    $stmt->close();
}
?>


