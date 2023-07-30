<!-- add_item.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function validateForm() {
            var itemCode = document.forms["itemForm"]["item_code"].value;
            var itemName = document.forms["itemForm"]["item_name"].value;
            var quantity = document.forms["itemForm"]["quantity"].value;
            var unitPrice = document.forms["itemForm"]["unit_price"].value;

            if (itemCode === "") {
                alert("Please enter the item code.");
                return false;
            }

            if (itemName === "") {
                alert("Please enter the item name.");
                return false;
            }

            if (isNaN(quantity) || parseInt(quantity) <= 0) {
                alert("Please enter a valid quantity.");
                return false;
            }

            if (isNaN(unitPrice) || parseFloat(unitPrice) <= 0) {
                alert("Please enter a valid unit price.");
                return false;
            }
        }
    </script>
</head>
<body>
    <h2>Add Item</h2>
    <form name="itemForm" action="process_item.php" method="POST" onsubmit="return validateForm()">
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
</body>
</html>
