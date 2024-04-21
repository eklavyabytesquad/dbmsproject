<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch the most recent ReceivingBranchID from the database
$sql = "SELECT MAX(ReceivingBranchID) AS max_branch_id FROM ReceivingBranch";
$result = $conn->query($sql);
$max_branch_id = 1; // Default value if no ReceivingBranchID is found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_branch_id = $row["max_branch_id"] ? $row["max_branch_id"] + 1 : 1;
}

// Initialize variables
$receiving_branch_id = $max_branch_id;
$bill_no = $receiver_id = $challan_id = "";
$bill_no_err = $receiver_id_err = $challan_id_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate ReceivingBranchID
    $receiving_branch_id = trim($_POST["receiving_branch_id"]);
    if (empty($receiving_branch_id)) {
        $receiving_branch_id_err = "Please enter ReceivingBranchID.";
    }

    // Validate BillNo
    $bill_no = trim($_POST["bill_no"]);
    if (empty($bill_no)) {
        $bill_no_err = "Please enter BillNo.";
    }

    // Validate ReceiverID
    $receiver_id = trim($_POST["receiver_id"]);
    if (empty($receiver_id)) {
        $receiver_id_err = "Please enter ReceiverID.";
    }

    // Validate ChallanID
    $challan_id = trim($_POST["challan_id"]);
    if (empty($challan_id)) {
        $challan_id_err = "Please enter ChallanID.";
    }

    // Check input errors before inserting into database
    if (empty($receiving_branch_id_err) && empty($bill_no_err) && empty($receiver_id_err) && empty($challan_id_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO ReceivingBranch (ReceivingBranchID, BillNo, ReceiverID, ChallanID) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iiii", $receiving_branch_id, $bill_no, $receiver_id, $challan_id);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success message
                echo "Data inserted successfully.";
                // Reset variables
                $receiving_branch_id = $bill_no = $receiver_id = $challan_id = "";
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
    <title>Insert Receiving Branch Data</title>
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
    <h2 style="text-align: center;">Insert Receiving Branch Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>ReceivingBranchID:</label>
            <input type="text" name="receiving_branch_id" value="<?php echo $receiving_branch_id; ?>">
        </div>
        <div class="form-group">
            <label>BillNo:</label>
            <input type="text" name="bill_no">
        </div>
        <div class="form-group">
            <label>ReceiverID:</label>
            <input type="text" name="receiver_id">
        </div>
        <div class="form-group">
            <label>ChallanID:</label>
            <input type="text" name="challan_id">
        </div>
        <div>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset" onclick="location.reload();">
        </div>
    </form>
</body>
</html>
