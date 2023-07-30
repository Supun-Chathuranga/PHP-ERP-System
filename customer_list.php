<?php
// customer_list.php
require_once "includes/db_config.php";

// Retrieve customer data from the database
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Customer List</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>District</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["first_name"]; ?></td>
            <td><?php echo $row["last_name"]; ?></td>
            <td><?php echo $row["contact_number"]; ?></td>
            <td><?php echo $row["district"]; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
