<!DOCTYPE html>
<html>
<head>
    <title>Invoice Report</title>
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

            <?php
            // Process the form data when the form is submitted
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                require_once "includes/db_config.php";

                // Sanitize and validate form data (implement form validation here)
                $startDate = $_POST["start_date"];
                $endDate = $_POST["end_date"];
                $search_keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';

                // Convert date format for the SQL query
                $startDate = date("Y-m-d", strtotime($startDate));
                $endDate = date("Y-m-d", strtotime($endDate));

                // Prepare and execute the SQL query to retrieve the invoice report data
                $sql = "SELECT invoice.invoice_no, invoice.date AS invoice_date, 
                            customer.first_name, customer.last_name, district.district AS customer_district,
                            COUNT(invoice_master.id) AS item_count, SUM(invoice_master.amount) AS invoice_amount
                        FROM invoice
                        JOIN invoice_master ON invoice.invoice_no = invoice_master.invoice_no
                        JOIN item ON invoice_master.item_id = item.id
                        JOIN customer ON invoice.customer = customer.id
                        JOIN district ON customer.district = district.id
                        WHERE invoice.date BETWEEN ? AND ?
                        AND (invoice.invoice_no LIKE ? OR item.item_name LIKE ?)
                        GROUP BY invoice.invoice_no, invoice.date, customer.first_name, customer.last_name, district.district
                        ORDER BY invoice.date";

                $stmt = $conn->prepare($sql);
                $search_keyword = "%" . $search_keyword . "%"; // Add wildcards for searching
                $stmt->bind_param("ssss", $startDate, $endDate, $search_keyword, $search_keyword);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

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
                        <td><?php echo $row["invoice_no"]; ?></td>
                        <td><?php echo $row["invoice_date"]; ?></td>
                        <td><?php echo $row["first_name"] . " " . $row["last_name"]; ?></td>
                        <td><?php echo $row["customer_district"]; ?></td>
                        <td><?php echo $row["item_count"]; ?></td>
                        <td><?php echo $row["invoice_amount"]; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>

                <?php
                // Close the prepared statement
                $stmt->close();

                // Close the database connection
                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>
