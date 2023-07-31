<!-- item_report.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Item Report</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Item Report</h2>
            <table>
                <tr>
                    <th>Item Name</th>
                    <th>Item Category</th>
                    <th>Item Subcategory</th>
                    <th>Item Quantity</th>
                </tr>
                <?php
                // Perform the query to retrieve item report data
                require_once "includes/db_config.php";

                $sql = "SELECT i.item_name, ic.category, isc.sub_category, SUM(i.quantity) AS total_quantity
                        FROM item AS i
                        INNER JOIN item_category AS ic ON i.item_category = ic.id
                        INNER JOIN item_subcategory AS isc ON i.item_subcategory = isc.id
                        GROUP BY i.item_name, ic.category, isc.sub_category
                        ORDER BY i.item_name";
                $result = $conn->query($sql);

                $previousItemName = null; // Variable to keep track of previous item name

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $itemName = $row["item_name"];
                        $category = $row["category"];
                        $subcategory = $row["sub_category"];
                        $totalQuantity = $row["total_quantity"];

                        // Display the item name only when it changes
                        if ($itemName !== $previousItemName) {
                            ?>
                            <tr>
                                <td><?php echo $itemName; ?></td>
                                <td><?php echo $category; ?></td>
                                <td><?php echo $subcategory; ?></td>
                                <td><?php echo $totalQuantity; ?></td>
                            </tr>
                            <?php
                            $previousItemName = $itemName; // Update the previous item name
                        } else {
                            // For consecutive rows with the same item name, display an empty cell for item name
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $category; ?></td>
                                <td><?php echo $subcategory; ?></td>
                                <td><?php echo $totalQuantity; ?></td>
                            </tr>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">No items found in the report.</td>
                    </tr>
                    <?php
                }

                // Close the database connection
                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
