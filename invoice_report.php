<!-- invoice_report.php -->
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
        </div>
    </div>
</body>
</html>
