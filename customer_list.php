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
                    <th>Actions</th>
                </tr>
                <?php
                // Perform the query to retrieve customer data
                require_once "includes/db_config.php";

                $sql = "SELECT c.*, d.district AS district_name FROM customer c LEFT JOIN district d ON c.district = d.id";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row["title"]; ?></td>
                            <td><?php echo $row["first_name"]; ?></td>
                            <td><?php echo $row["last_name"]; ?></td>
                            <td><?php echo isset($row["contact_no"]) ? $row["contact_no"] : ""; ?></td>
                            <td>
                                <?php
                                // Retrieve the district name from the database based on the district ID
                                echo isset($row["district_name"]) ? $row["district_name"] : "Unknown District";
                                ?>
                            </td>
                            <td>
                                <!-- Add update and delete buttons for each customer -->
                                <a href="update_customer.php?id=<?php echo $row['id']; ?>">Update</a>
                                <!-- Add the confirmation pop-up for the Delete button -->
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>);">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6">No customers found in the list.</td>
                    </tr>
                    <?php
                }

                // Close the database connection
                $conn->close();
                ?>
            </table>
        </div>
    </div>

    <script>
        // Function to display a confirmation pop-up before deleting a customer
        function confirmDelete(customerId) {
            var confirmation = confirm("Are you sure you want to delete this customer?");
            if (confirmation) {
                // If the user confirms, redirect to the delete_customer.php with the customer ID
                window.location.href = "delete_customer.php?id=" + customerId;
            }
        }
    </script>
</body>
</html>
