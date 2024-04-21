<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch the most recent SenderID from the database
$sql = "SELECT MAX(SenderID) AS max_sender_id FROM Sender";
$result = $conn->query($sql);
$max_sender_id = 1; // Default value if no SenderID is found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_sender_id = $row["max_sender_id"] ? $row["max_sender_id"] + 1 : 1;
}

// Initialize variables
$sender_id = $max_sender_id;
$phone_no = $goods_category = "";
$sender_id_err = $phone_no_err = $goods_category_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate SenderID
    $sender_id = trim($_POST["sender_id"]);
    if (empty($sender_id)) {
        $sender_id_err = "Please enter SenderID.";
    }

    // Validate PhoneNo
    $phone_no = trim($_POST["phone_no"]);
    if (empty($phone_no)) {
        $phone_no_err = "Please enter PhoneNo.";
    }

    // Validate GoodsCategory
    $goods_category = trim($_POST["goods_category"]);
    if (empty($goods_category)) {
        $goods_category_err = "Please enter GoodsCategory.";
    }

    // Check input errors before inserting into database
    if (empty($sender_id_err) && empty($phone_no_err) && empty($goods_category_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Sender (SenderID, PhoneNo, GoodsCategory) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iss", $sender_id, $phone_no, $goods_category);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success message
                echo "Data inserted successfully.";
                // Reset variables
                $sender_id = $phone_no = $goods_category = "";
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
    <title>Insert Sender Data</title>
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
    <h2 style="text-align: center;">Insert Sender Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>SenderID:</label>
            <input type="text" name="sender_id" value="<?php echo $sender_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label>PhoneNo:</label>
            <input type="text" name="phone_no">
        </div>
        <div class="form-group">
            <label>GoodsCategory:</label>
            <input type="text" name="goods_category">
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
