<!-- add_customer.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Function to display a success message as a pop-up
        function showSuccessMessage() {
            var alertContainer = document.createElement('div');
            alertContainer.setAttribute('style', 'display: flex; justify-content: center; align-items: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);');

            var alertBox = document.createElement('div');
            alertBox.setAttribute('style', 'background-color: #f3f3f3; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);');

            var message = document.createElement('p');
            message.textContent = 'Customer added successfully!';
            message.setAttribute('style', 'margin: 0; font-size: 16px; color: #333;');

            var okButton = document.createElement('button');
            okButton.textContent = 'OK';
            okButton.setAttribute('style', 'background-color: #4CAF50; color: #fff; border: none; padding: 10px 15px; text-align: center; text-decoration: none; font-size: 14px; cursor: pointer; align: center;');

            okButton.onclick = function() {
                alertContainer.style.display = 'none';
            };

            alertBox.appendChild(message);
            alertBox.appendChild(okButton);
            alertContainer.appendChild(alertBox);
            document.body.appendChild(alertContainer);
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Add Customer</h2>
            <?php
            // Check if the success query parameter is present in the URL
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "<script>showSuccessMessage();</script>";
            }
            ?>
            <form name="customerForm" action="process_customer.php" method="POST">
                <!-- Your Add Customer form content goes here -->
                <label>Title:</label>
                <select name="title" required>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Dr">Dr</option>
                </select><br>
                <label>First Name:</label>
                <input type="text" name="first_name" required><br>
                <label>Last Name:</label>
                <input type="text" name="last_name" required><br>
                <label>Contact No:</label>
                <input type="text" name="contact_no" required><br>
                <label>District:</label>
                <select name="district" required>
                    <option value="">Select District</option>
                    <?php
                    // Perform the query to retrieve district data
                    require_once "includes/db_config.php";

                    $district_sql = "SELECT * FROM district";
                    $district_result = $conn->query($district_sql);
                    while ($district_row = $district_result->fetch_assoc()) {
                        echo "<option value='" . $district_row['id'] . "'>" . $district_row['district'] . "</option>";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </select><br>
                <input type="submit" value="Save">
            </form>
        </div>
    </div>
</body>
</html>
