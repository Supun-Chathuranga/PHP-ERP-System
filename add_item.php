<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function validateForm() {
            // Validation logic goes here...
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Add Item</h2>
            <form name="itemForm" action="process_item.php" method="POST" onsubmit="return validateForm()">
                <!-- Your Add Item form content goes here -->
                <label>Item Code:</label>
                <input type="text" name="item_code" required><br>
                <label>Item Name:</label>
                <input type="text" name="item_name" required><br>
                <label>Item Category:</label>
                <input type="text" name="item_category"><br>
                <label>Item Sub Category:</label>
                <input type="text" name="item_subcategory"><br>
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
