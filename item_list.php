<?php
require_once "includes/db_config.php";

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
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Item List</h2>
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
                        <!-- Add update and delete buttons for each item -->
                        <a href="update_item.php?id=<?php echo $row['id']; ?>">Update</a>
                        <a href="delete_item.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
