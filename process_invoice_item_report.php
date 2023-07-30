<?php
// process_invoice_item_report.php
require_once "includes/db_config.php";

$searchKeyword = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data (implement form validation here)
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $searchKeyword = $_POST["search_keyword"];

    // Perform server-side validation
    if (empty($startDate) || empty($endDate)) {
        // Handle validation errors and redirect back to the invoice item report with error messages
        header("Location: invoice_item_report.php?error=1");
        exit();
    }

    // Convert date format for the SQL query
    $startDate = date("Y-m-d", strtotime($startDate));
    $endDate = date("Y-m-d", strtotime($endDate));

    // Prepare and execute the SQL query to retrieve the invoice item report data
    $sql = "SELECT invoices.invoice_number, invoices.invoice_date, 
            CONCAT(customers.first_name, ' ', customers.last_name) AS customer_name,
            items.item_name, items.item_code, items.item_category, items.unit_price
            FROM invoices
            INNER JOIN customers ON invoices.customer_id = customers.id
            INNER JOIN items ON invoices.item_id = items.id
            WHERE invoice_date BETWEEN ? AND ?
            AND (invoices.invoice_number LIKE ? OR customers.first_name LIKE ? OR customers.last_name LIKE ?)";
    $stmt = $conn->prepare($sql);
    $searchKeyword = "%$searchKeyword%"; // Add wildcards for searching
    $stmt->bind_param("sss", $startDate, $endDate, $searchKeyword, $searchKeyword, $searchKeyword);
    $stmt->execute();
    $result = $stmt->get_result();

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Item Report</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Invoice Item Report</h2>
    <form action="process_invoice_item_report.php" method="POST">
        <label>Start Date:</label>
        <input type="date" name="start_date" required><br>
        <label>End Date:</label>
        <input type="date" name="end_date" required><br>
        <label>Search Keyword:</label>
        <input type="text" name="search_keyword" value="<?php echo htmlspecialchars($searchKeyword); ?>"><br>
        <input type="submit" value="Generate Report">
    </form>

    <h3>Invoice Item Report Results</h3>
    <table>
        <tr>
            <th>Invoice Number</th>
            <th>Invoiced Date</th>
            <th>Customer Name</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>Item Category</th>
            <th>Item Unit Price</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row["invoice_number"]; ?></td>
            <td><?php echo $row["invoice_date"]; ?></td>
            <td><?php echo $row["customer_name"]; ?></td>
            <td><?php echo $row["item_name"]; ?></td>
            <td><?php echo $row["item_code"]; ?></td>
            <td><?php echo $row["item_category"]; ?></td>
            <td><?php echo $row["unit_price"]; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
