<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Function to display a success message as a pop-up
        function showSuccessMessage() {
            var alertContainer = document.createElement('div');
            alertContainer.setAttribute('style', 'display: flex; justify-content: center; align-items: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);');

            var alertBox = document.createElement('div');
            alertBox.setAttribute('style', 'background-color: #f3f3f3; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);');

            var message = document.createElement('p');
            message.textContent = 'Item added successfully!';
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
            <h2>Add Item</h2>
            <?php
            // Check if the success query parameter is present in the URL
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "<script>showSuccessMessage();</script>";
            }
            ?>
            <form name="itemForm" action="process_item.php" method="POST">
                <!-- Your Add Item form content goes here -->
                <label>Item Code:</label>
                <input type="text" name="item_code" required><br>
                <label>Item Name:</label>
                <input type="text" name="item_name" required><br>
                <label>Item Category:</label>
                <select name="item_category" required>
                    <option value="">Select Category</option>
                    <!-- Fetch and display item categories from the database -->
                    <?php
                    require_once "includes/db_config.php";
                    $sql = "SELECT * FROM item_category";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
                    }
                    ?>
                </select><br>
                <label>Item Sub Category:</label>
                <select name="item_subcategory" required>
                    <option value="">Select Sub Category</option>
                    <!-- Fetch and display item subcategories from the database -->
                    <?php
                    $sql = "SELECT * FROM item_subcategory";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['sub_category'] . "</option>";
                    }
                    ?>
                </select><br>
                <label>Quantity:</label>
                <input type="number" name="quantity" min="1" required><br>
                <label>Unit Price:</label>
                <input type="number" step="0.01" name="unit_price" min="0" required><br>
                <input type="submit" value="Save">
            </form>
        </div>
    </div>
</body>
</html>
