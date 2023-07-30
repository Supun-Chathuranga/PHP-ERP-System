<!-- customer_list.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Customer List</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact Number</th>
                    <th>District</th>
                </tr>
                <?php
                // Perform the query to retrieve customer data
                require_once "includes/db_config.php";

                $sql = "SELECT * FROM customer";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row["title"]; ?></td>
                            <td><?php echo $row["first_name"]; ?></td>
                            <td><?php echo $row["last_name"]; ?></td>
                            <td><?php echo isset($row["contact_no"]) ? $row["contact_no"] : ""; ?></td>
                            <td><?php echo $row["district"]; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5">No customers found in the list.</td>
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
