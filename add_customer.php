<!-- add_customer.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function validateForm() {
            var firstName = document.forms["customerForm"]["first_name"].value;
            var lastName = document.forms["customerForm"]["last_name"].value;
            var contactNumber = document.forms["customerForm"]["contact_number"].value;

            if (firstName === "") {
                alert("Please enter the first name.");
                return false;
            }

            if (lastName === "") {
                alert("Please enter the last name.");
                return false;
            }

            // Optional validation for contact number
            if (contactNumber !== "" && !/^\d{10}$/.test(contactNumber)) {
                alert("Please enter a valid 10-digit contact number.");
                return false;
            }
        }
    </script>
</head>
<body>
    <h2>Add Customer</h2>
    <form name="customerForm" action="process_customer.php" method="POST" onsubmit="return validateForm()">
        <label>Title:</label>
        <select name="title">
            <option value="Mr">Mr</option>
            <option value="Mrs">Mrs</option>
            <option value="Miss">Miss</option>
            <option value="Dr">Dr</option>
        </select><br>
        <label>First Name:</label>
        <input type="text" name="first_name" required><br>
        <label>Last Name:</label>
        <input type="text" name="last_name" required><br>
        <label>Contact Number:</label>
        <input type="text" name="contact_number" pattern="\d{10}" title="Please enter a 10-digit contact number."><br>
        <label>District:</label>
        <input type="text" name="district"><br>
        <input type="submit" value="Save">
    </form>
</body>
</html>

