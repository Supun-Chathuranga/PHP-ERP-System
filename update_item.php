<?php
require_once "includes/db_config.php";

// Retrieve category and subcategory options from the database
$category_sql = "SELECT * FROM item_category";
$category_result = $conn->query($category_sql);

$subcategory_sql = "SELECT * FROM item_subcategory";
$subcategory_result = $conn->query($subcategory_sql);

// Initialize variables
$item_code = $item_name = $item_category = $item_subcategory = $quantity = $unit_price = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_item"])) {
        // Retrieve data from the form submission
        $item_id = $_POST['item_id'];
        $item_code = $_POST['item_code'];
        $item_name = $_POST['item_name'];
        $item_category = $_POST['item_category'];
        $item_subcategory = $_POST['item_subcategory'];
        $quantity = $_POST['quantity'];
        $unit_price = $_POST['unit_price'];

        // Update the item in the database
        $update_sql = "UPDATE item SET
                       item_code = '$item_code',
                       item_name = '$item_name',
                       item_category = '$item_category',
                       item_subcategory = '$item_subcategory',
                       quantity = '$quantity',
                       unit_price = '$unit_price'
                       WHERE id = $item_id";

        if ($conn->query($update_sql) === TRUE) {
            // Redirect to the item list page with a success flag in the URL
            header("Location: item_list.php?success=1");
            exit();
        } else {
            echo "Error updating item: " . $conn->error;
        }
    }
} else {
    // Check if the item ID is provided in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $item_id = $_GET['id'];

        // Retrieve item data from the database based on the item ID
        $item_sql = "SELECT * FROM item WHERE id = $item_id";
        $item_result = $conn->query($item_sql);

        if ($item_result->num_rows === 1) {
            // Fetch item details
            $item_row = $item_result->fetch_assoc();
            $item_code = $item_row["item_code"];
            $item_name = $item_row["item_name"];
            $item_category = $item_row["item_category"];
            $item_subcategory = $item_row["item_subcategory"];
            $quantity = $item_row["quantity"];
            $unit_price = $item_row["unit_price"];
        } else {
            echo "Item not found.";
            exit();
        }
    } else {
        echo "Invalid item ID.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Item</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Update Item</h2>
            <form name="itemForm" action="" method="POST">
                <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                <label>Item Code:</label>
                <input type="text" name="item_code" value="<?php echo $item_code; ?>" required><br>
                <label>Item Name:</label>
                <input type="text" name="item_name" value="<?php echo $item_name; ?>" required><br>
                <label>Item Category:</label>
                <select name="item_category" required>
                    <option value="">Select Category</option>
                    <?php while ($category_row = $category_result->fetch_assoc()) : ?>
                        <option value="<?php echo $category_row['id']; ?>" <?php echo ($item_category == $category_row['id']) ? 'selected' : ''; ?>>
                            <?php echo $category_row['category']; ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>
                <label>Item Subcategory:</label>
                <select name="item_subcategory" required>
                    <option value="">Select Subcategory</option>
                    <?php while ($subcategory_row = $subcategory_result->fetch_assoc()) : ?>
                        <option value="<?php echo $subcategory_row['id']; ?>" <?php echo ($item_subcategory == $subcategory_row['id']) ? 'selected' : ''; ?>>
                            <?php echo $subcategory_row['sub_category']; ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>
                <label>Quantity:</label>
                <input type="text" name="quantity" value="<?php echo $quantity; ?>" required><br>
                <label>Unit Price:</label>
                <input type="text" name="unit_price" value="<?php echo $unit_price; ?>" required><br>
                <input type="submit" name="update_item" value="Update">
            </form>
        </div>
    </div>
</body>
</html>
