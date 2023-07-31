<?php
// process_invoice_item_report.php
require_once "includes/db_config.php";

$searchKeyword = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data (implement form validation here)
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $searchKeyword = $_POST["search_keyword"] ?? '';

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
    $sql = "SELECT invoice.invoice_no, invoice.date AS invoice_date, customer.first_name, customer.last_name, 
               item.item_name, item.item_code, item.item_category, invoice_master.unit_price
            FROM invoice
            JOIN invoice_master ON invoice.invoice_no = invoice_master.invoice_no
            JOIN item ON invoice_master.item_id = item.id
            JOIN customer ON invoice.customer = customer.id
            WHERE invoice.date BETWEEN ? AND ?
            AND (invoice.invoice_no LIKE ? OR item.item_name LIKE ?)
            ORDER BY invoice.date";

    $stmt = $conn->prepare($sql);

    // Add wildcards for searching
    $searchKeyword = "%$searchKeyword%";
    // Adjust the type definition string to match the number of placeholders (4 placeholders here)
    $stmt->bind_param("ssss", $startDate, $endDate, $searchKeyword, $searchKeyword);
    $stmt->execute();
    $result = $stmt->get_result();

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Invoice Item Report</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <div class="content">
            <h2>Invoice Report</h2>
            <form action="process_invoice_report.php" method="POST">
                <div class="form-row">
                    <div class="form-column">
                        <label>Start Date:</label>
                        <input type="date" name="start_date" required>
                    </div>
                    <div class="form-column">
                        <label>End Date:</label>
                        <input type="date" name="end_date" required>
                    </div>
                    <div class="form-column">
                        <label>Search Keyword:</label>
                        <input type="text" name="search_keyword" placeholder="Keyword">
                    </div>
                    <div class="form-column">
                        <input type="submit" value="Generate Report">
                    </div>
                </div>
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
                    <td><?php echo $row["invoice_no"]; ?></td>
                    <td><?php echo $row["invoice_date"]; ?></td>
                    <td><?php echo $row["first_name"] . " " . $row["last_name"]; ?></td>
                    <td><?php echo $row["item_name"]; ?></td>
                    <td><?php echo $row["item_code"]; ?></td>
                    <td><?php echo $row["item_category"]; ?></td>
                    <td><?php echo $row["unit_price"]; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
