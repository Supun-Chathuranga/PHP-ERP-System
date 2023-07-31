<?php
require_once "includes/db_config.php";

// Function to delete an item by ID
function deleteItem($conn, $item_id) {
    $delete_sql = "DELETE FROM item WHERE id = $item_id";
    if ($conn->query($delete_sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Check if the item ID is provided in the URL and is a valid numeric value
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $item_id = $_GET['id'];

    // Check if the delete button is clicked
    if (isset($_GET['delete']) && $_GET['delete'] === "true") {
        if (deleteItem($conn, $item_id)) {
            // Item deleted successfully, redirect to the item list page with a success flag in the URL
            header("Location: item_list.php?success=1");
            exit();
        } else {
            // Failed to delete the item, display an error message
            $error_message = "Error deleting item: " . $conn->error;
        }
    }
}

// Retrieve item data from the database with category and subcategory names
$sql = "SELECT item.id, item.item_code, item.item_name, category.category as item_category, subcategory.sub_category as item_subcategory, item.quantity, item.unit_price
        FROM item
        LEFT JOIN item_category category ON item.item_category = category.id
        LEFT JOIN item_subcategory subcategory ON item.item_subcategory = subcategory.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Function to display a confirmation pop-up before deleting an item
        function confirmDelete(itemId) {
            var confirmation = confirm("Are you sure you want to delete this item?");
            if (confirmation) {
                // If the user confirms, redirect to the item list page with delete flag in the URL
                window.location.href = "item_list.php?delete=true&id=" + itemId;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Item List</h2>
            <?php if (isset($error_message)) : ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <table>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Category</th>
                    <th>Item Subcategory</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row["item_code"]; ?></td>
                    <td><?php echo $row["item_name"]; ?></td>
                    <td><?php echo $row["item_category"]; ?></td>
                    <td><?php echo $row["item_subcategory"]; ?></td>
                    <td><?php echo $row["quantity"]; ?></td>
                    <td><?php echo $row["unit_price"]; ?></td>
                    <td>
                        <!-- Add delete button for each item with the onclick event -->
                        <a href="update_item.php?id=<?php echo $row['id']; ?>">Update</a>
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>);">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
