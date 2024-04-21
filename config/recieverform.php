<?php
require_once "conn.php";
require_once "navbar.php";
// Fetch the most recent ReceiverID from the database
$sql = "SELECT MAX(ReceiverID) AS max_receiver_id FROM Receiver";
$result = $conn->query($sql);
$max_receiver_id = 1; // Default value if no ReceiverID is found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_receiver_id = $row["max_receiver_id"] ? $row["max_receiver_id"] + 1 : 1;
}

// Define variables and initialize with empty values
$receiver_id = $max_receiver_id;
$phone_no = $address = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate ReceiverID
    $receiver_id = trim($_POST["receiver_id"]);

    // Validate PhoneNo
    $phone_no = trim($_POST["phone_no"]);

    // Validate Address
    $address = trim($_POST["address"]);

    // Check input errors before inserting into database
    if (!empty($receiver_id) && !empty($phone_no) && !empty($address)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Receiver (ReceiverID, PhoneNo, Address) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iss", $receiver_id, $phone_no, $address);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success message or do any other action
                echo "Data inserted successfully.";
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
    <title>Insert Receiver Data</title>
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
        input[type="submit"], input[type="reset"], input[type="button"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Insert Receiver Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>ReceiverID:</label>
            <input type="text" name="receiver_id" value="<?php echo $max_receiver_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label>PhoneNo:</label>
            <input type="text" name="phone_no" value="">
        </div>
        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" value="">
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

