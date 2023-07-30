<?php
// item_list.php
require_once "includes/db_config.php";

// Retrieve item data from the database
$sql = "SELECT * FROM item";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Item List</h2>
    <table>
        <tr>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Category</th>
            <th>Item Subcategory</th>
            <th>Quantity</th>
            <th>Unit Price</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row["item_code"]; ?></td>
            <td><?php echo $row["item_name"]; ?></td>
            <td><?php echo $row["item_category"]; ?></td>
            <td><?php echo $row["item_subcategory"]; ?></td>
            <td><?php echo $row["quantity"]; ?></td>
            <td><?php echo $row["unit_price"]; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
