<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch the most recent ChallanID from the database
$sql = "SELECT MAX(ChallanID) AS max_challan_id FROM Challan";
$result = $conn->query($sql);
$max_challan_id = 1; // Default value if no ChallanID is found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_challan_id = $row["max_challan_id"] ? intval($row["max_challan_id"]) + 1 : 1;
}

// Initialize variables
$challan_id = sprintf("%03d", $max_challan_id);
$driver_id = $truck_no = "";
$challan_id_err = $driver_id_err = $truck_no_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate ChallanID
    $challan_id = trim($_POST["challan_id"]);
    if (empty($challan_id)) {
        $challan_id_err = "Please enter ChallanID.";
    }

    // Validate DriverID
    $driver_id = trim($_POST["driver_id"]);
    if (empty($driver_id)) {
        $driver_id_err = "Please enter DriverID.";
    }

    // Validate TruckNo
    $truck_no = trim($_POST["truck_no"]);
    if (empty($truck_no)) {
        $truck_no_err = "Please enter TruckNo.";
    }

    // Check input errors before inserting into database
    if (empty($challan_id_err) && empty($driver_id_err) && empty($truck_no_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Challan (ChallanID, DriverID, TruckNo) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sis", $challan_id, $driver_id, $truck_no);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success message
                echo "Data inserted successfully.";
                // Reset variables
                $challan_id = sprintf("%03d", intval($challan_id) + 1);
                $driver_id = $truck_no = "";
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
    <title>Insert Challan Data</title>
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
    <h2 style="text-align: center;">Insert Challan Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>ChallanID:</label>
            <input type="text" name="challan_id" value="<?php echo $challan_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label>DriverID:</label>
            <input type="text" name="driver_id">
        </div>
        <div class="form-group">
            <label>TruckNo:</label>
            <input type="text" name="truck_no">
        </div>
        <div>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset" onclick="location.reload();">
        </div>
    </form>
</body>
</html>
