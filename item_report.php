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

                $sql = "SELECT item_name, item_category, item_subcategory, SUM(quantity) AS total_quantity
                        FROM item
                        GROUP BY item_name, item_category, item_subcategory
                        ORDER BY item_name";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row["item_name"]; ?></td>
                            <td><?php echo $row["item_category"]; ?></td>
                            <td><?php echo $row["item_subcategory"]; ?></td>
                            <td><?php echo $row["total_quantity"]; ?></td>
                        </tr>
                        <?php
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
