<?php
// process_invoice_report.php
require_once "includes/db_config.php";

$searchKeyword = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data (implement form validation here)
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $searchKeyword = $_POST["search_keyword"];

    // Perform server-side validation
    if (empty($startDate) || empty($endDate)) {
        // Handle validation errors and redirect back to the invoice report with error messages
        header("Location: invoice_report.php?error=1");
        exit();
    }

    // Convert date format for the SQL query
    $startDate = date("Y-m-d", strtotime($startDate));
    $endDate = date("Y-m-d", strtotime($endDate));

    // Prepare and execute the SQL query to retrieve the invoice report data
    $sql = "SELECT invoice_number, invoice_date, customer_name, customer_district, 
            COUNT(item_id) AS item_count, SUM(item_unit_price) AS invoice_amount
            FROM invoices
            WHERE invoice_date BETWEEN ? AND ?
            AND (invoice_number LIKE ? OR customer_name LIKE ? OR customer_district LIKE ?)
            GROUP BY invoice_number";
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
    <title>Invoice Report</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Invoice Report</h2>
    <form action="process_invoice_report.php" method="POST">
        <label>Start Date:</label>
        <input type="date" name="start_date" required><br>
        <label>End Date:</label>
        <input type="date" name="end_date" required><br>
        <label>Search Keyword:</label>
        <input type="text" name="search_keyword" value="<?php echo htmlspecialchars($searchKeyword); ?>"><br>
        <input type="submit" value="Generate Report">
    </form>

    <h3>Invoice Report Results</h3>
    <table>
        <tr>
            <th>Invoice Number</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Customer District</th>
            <th>Item Count</th>
            <th>Invoice Amount</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row["invoice_number"]; ?></td>
            <td><?php echo $row["invoice_date"]; ?></td>
            <td><?php echo $row["customer_name"]; ?></td>
            <td><?php echo $row["customer_district"]; ?></td>
            <td><?php echo $row["item_count"]; ?></td>
            <td><?php echo $row["invoice_amount"]; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
