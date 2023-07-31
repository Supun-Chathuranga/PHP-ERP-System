# PHP-ERP-System
PHP ERP System for a Assignment

Assumptions made:

1. The project is a PHP-based ERP system for managing customers and items.
2. The project uses a MySQL database to store customer and item data.
3. The project has separate pages for listing, updating, and deleting customers and items.
4. The database connection settings are defined in the "db_config.php" file, which is included in each PHP file that requires database access.
5. The project uses HTML, CSS, and JavaScript for front-end display and interactions.
6. The "includes" folder contains the "db_config.php" file
7. Search option use for only Reports

How to set up the project in a local environment:

1. Installed a local web server (XAMPP) on my computer to run PHP and MySQL.
2. Create the project files in my local web server's document root directory (htdocs).
3. Create a new database in my local MySQL server, and import the provided SQL dump file ("assignment.sql") to create the necessary tables and insert sample data.
4. Update the "db_config.php" file inside the "includes" folder with my local database connection details (host ,database name, username, password).
5. Start my local web server and navigate to the project URL in my web browser (e.g., "http://localhost/PHP-ERP-System/index.php").
6. The project's home page should be displayed, showing a list of customers,items along with options to update and delete them and Reports.
7. click on the "Update" links to navigate to the respective update pages (e.g., "update_customer.php" or "update_item.php") and make changes.
8. To delete a customer or item, click on the "Delete" link, and a confirmation popup will appear. If confirmed, the item will be deleted, and redirected back to the list page.
