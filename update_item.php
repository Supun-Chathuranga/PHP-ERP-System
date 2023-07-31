<?php
require_once "includes/db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the item ID from the URL parameter
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $item_id = $_GET['id'];

        // Retrieve item data from the database
        $sql = "SELECT * FROM item WHERE id = $item_id";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            // Fetch item details
            $row = $result->fetch_assoc();
            $item_code = $_POST['item_code'];
            $item_name = $_POST['item_name'];
            $item_category = $_POST['item_category'];
            $item_subcategory = $_POST['item_subcategory'];
            $quantity = $_POST['quantity'];
            $unit_price = $_POST['unit_price'];

            // Update item in the database
            $update_sql = "UPDATE item SET item_code = '$item_code', item_name = '$item_name', 
                           item_category = '$item_category', item_subcategory = '$item_subcategory', 
                           quantity = '$quantity', unit_price = '$unit_price' 
                           WHERE id = $item_id";

            if ($conn->query($update_sql) === TRUE) {
                // Redirect to the item list page after successful update
                header("Location: item_list.php?success=1");
                exit();
            } else {
                echo "Error updating item: " . $conn->error;
            }
        } else {
            echo "Item not found.";
            exit();
        }
    } else {
        echo "Invalid item ID.";
        exit();
    }
} else {
    // Retrieve the item ID from the URL parameter
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $item_id = $_GET['id'];

        // Retrieve item data from the database
        $sql = "SELECT * FROM item WHERE id = $item_id";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            // Fetch item details
            $row = $result->fetch_assoc();
            $item_code = $row["item_code"];
            $item_name = $row["item_name"];
            $item_category = $row["item_category"];
            $item_subcategory = $row["item_subcategory"];
            $quantity = $row["quantity"];
            $unit_price = $row["unit_price"];
        } else {
            echo "Item not found.";
            exit();
        }
    } else {
        echo "Invalid item ID.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Item</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Update Item</h2>
            <form name="itemForm" action="" method="POST">
                <label>Item Code:</label>
                <input type="text" name="item_code" value="<?php echo $item_code; ?>" required><br>
                <label>Item Name:</label>
                <input type="text" name="item_name" value="<?php echo $item_name; ?>" required><br>
                <label>Item Category:</label>
                <input type="text" name="item_category" value="<?php echo $item_category; ?>" required><br>
                <label>Item Subcategory:</label>
                <input type="text" name="item_subcategory" value="<?php echo $item_subcategory; ?>" required><br>
                <label>Quantity:</label>
                <input type="text" name="quantity" value="<?php echo $quantity; ?>" required><br>
                <label>Unit Price:</label>
                <input type="text" name="unit_price" value="<?php echo $unit_price; ?>" required><br>
                <input type="submit" name="update_item" value="Update">
            </form>
        </div>
    </div>
</body>
</html>
