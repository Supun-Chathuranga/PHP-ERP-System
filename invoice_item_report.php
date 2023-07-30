<!-- invoice_item_report.php -->
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
            <h2>Invoice Item Report</h2>
            <form action="process_invoice_item_report.php" method="POST">
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
                        <label>Search Item:</label>
                        <input type="text" name="search_item" placeholder="Item name or code">
                    </div>
                    <div class="form-column">
                        <input type="submit" value="Generate Report">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
