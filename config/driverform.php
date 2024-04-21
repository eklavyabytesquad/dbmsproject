<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch the most recent DriverID from the database
$sql = "SELECT MAX(DriverID) AS max_driver_id FROM Driver";
$result = $conn->query($sql);
$max_driver_id = 1; // Default value if no DriverID is found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_driver_id = $row["max_driver_id"] ? $row["max_driver_id"] + 1 : 1;
}

// Initialize variables
$driver_id = $max_driver_id;
$name = $license = $phone_no = "";
$driver_id_err = $name_err = $license_err = $phone_no_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate DriverID
    $driver_id = trim($_POST["driver_id"]);
    if (empty($driver_id)) {
        $driver_id_err = "Please enter DriverID.";
    }

    // Validate Name
    $name = trim($_POST["name"]);
    if (empty($name)) {
        $name_err = "Please enter Name.";
    }

    // Validate License
    $license = trim($_POST["license"]);
    if (empty($license)) {
        $license_err = "Please enter License.";
    }

    // Validate PhoneNo
    $phone_no = trim($_POST["phone_no"]);
    if (empty($phone_no)) {
        $phone_no_err = "Please enter PhoneNo.";
    }

    // Check input errors before inserting into database
    if (empty($driver_id_err) && empty($name_err) && empty($license_err) && empty($phone_no_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Driver (DriverID, Name, License, PhoneNo) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("isss", $driver_id, $name, $license, $phone_no);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success message
                echo "Data inserted successfully.";
                // Reset variables
                $driver_id = $name = $license = $phone_no = "";
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Driver Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"], input[type="reset"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Insert Driver Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>DriverID:</label>
            <input type="text" name="driver_id" value="<?php echo $driver_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name">
        </div>
        <div class="form-group">
            <label>License:</label>
            <input type="text" name="license">
        </div>
        <div class="form-group">
            <label>PhoneNo:</label>
            <input type="text" name="phone_no">
        </div>
        <div>
            <input type="submit" value="Submit">
            <input type="button" value="Reset" onclick="refreshPage()">
        </div>
    </form>

    <script>
        function refreshPage() {
            location.reload();
        }
    </script>
</body>
</html>
