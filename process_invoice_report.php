<?php
// process_invoice_report.php
require_once "includes/db_config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data (implement form validation here)
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

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
    $sql = "SELECT invoices.invoice_number, invoices.invoice_date, customers.first_name, customers.last_name,
            customers.district, COUNT(items.id) AS item_count, SUM(items.unit_price * items.quantity) AS invoice_amount
            FROM invoices
            INNER JOIN customers ON invoices.customer_id = customers.id
            INNER JOIN items ON invoices.item_id = items.id
            WHERE invoice_date BETWEEN ? AND ?
            GROUP BY invoices.invoice_number, invoices.invoice_date, customers.first_name, customers.last_name,
            customers.district";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
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
            <td><?php echo $row["first_name"] . " " . $row["last_name"]; ?></td>
            <td><?php echo $row["district"]; ?></td>
            <td><?php echo $row["item_count"]; ?></td>
            <td><?php echo $row["invoice_amount"]; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
