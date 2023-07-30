<!-- invoice_report.php -->
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
</body>
</html>
