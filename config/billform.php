<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch the most recent BillNo from the database
$sql = "SELECT MAX(BillNo) AS max_bill_no FROM Bill";
$result = $conn->query($sql);
$max_bill_no = 1; // Default value if no BillNo is found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_bill_no = $row["max_bill_no"] ? $row["max_bill_no"] + 1 : 1;
}

// Initialize variables
$bill_no = $max_bill_no;
$receiving_branch_id = $sender_id = $receiver_id = "";
$receiving_branch_id_err = $sender_id_err = $receiver_id_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate BillNo
    $bill_no = trim($_POST["bill_no"]);
    if (empty($bill_no)) {
        $bill_no_err = "Please enter BillNo.";
    }

    // Validate ReceivingBranchID
    $receiving_branch_id = trim($_POST["receiving_branch_id"]);
    if (empty($receiving_branch_id)) {
        $receiving_branch_id_err = "Please enter ReceivingBranchID.";
    }

    // Validate SenderID
    $sender_id = trim($_POST["sender_id"]);
    if (empty($sender_id)) {
        $sender_id_err = "Please enter SenderID.";
    }

    // Validate ReceiverID
    $receiver_id = trim($_POST["receiver_id"]);
    if (empty($receiver_id)) {
        $receiver_id_err = "Please enter ReceiverID.";
    }

    // Check input errors before inserting into database
    if (empty($bill_no_err) && empty($receiving_branch_id_err) && empty($sender_id_err) && empty($receiver_id_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Bill (BillNo, ReceivingBranchID, SenderID, ReceiverID) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iiii", $bill_no, $receiving_branch_id, $sender_id, $receiver_id);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success message
                echo "Data inserted successfully.";
                // Reset variables
                $bill_no = $receiving_branch_id = $sender_id = $receiver_id = "";
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
    <title>Insert Bill Data</title>
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
    <h2 style="text-align: center;">Insert Bill Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>BillNo:</label>
            <input type="text" name="bill_no" value="<?php echo $bill_no; ?>">
        </div>
        <div class="form-group">
            <label>ReceivingBranchID:</label>
            <input type="text" name="receiving_branch_id">
        </div>
        <div class="form-group">
            <label>SenderID:</label>
            <input type="text" name="sender_id">
        </div>
        <div class="form-group">
            <label>ReceiverID:</label>
            <input type="text" name="receiver_id">
        </div>
        <div>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset" onclick="location.reload();">
        </div>
    </form>
</body>
</html>
