<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch the most recent StationID from the database
$sql = "SELECT MAX(StationID) AS max_station_id FROM MainStation";
$result = $conn->query($sql);
$max_station_id = 1; // Default value if no StationID is found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_station_id = $row["max_station_id"] ? $row["max_station_id"] + 1 : 1;
}

// Initialize variables
$station_id = $max_station_id;
$challan_id = $receiver_id = "";
$challan_id_err = $receiver_id_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate StationID
    $station_id = trim($_POST["station_id"]);
    if (empty($station_id)) {
        $station_id_err = "Please enter StationID.";
    }

    // Validate ChallanID
    $challan_id = trim($_POST["challan_id"]);
    if (empty($challan_id)) {
        $challan_id_err = "Please enter ChallanID.";
    }

    // Validate ReceiverID
    $receiver_id = trim($_POST["receiver_id"]);
    if (empty($receiver_id)) {
        $receiver_id_err = "Please enter ReceiverID.";
    }

    // Check input errors before inserting into database
    if (empty($station_id_err) && empty($challan_id_err) && empty($receiver_id_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO MainStation (StationID, ChallanID, ReceiverID) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iii", $station_id, $challan_id, $receiver_id);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success message
                echo "Data inserted successfully.";
                // Reset variables
                $station_id = $challan_id = $receiver_id = "";
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
    <title>Insert Main Station Data</title>
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
    <h2 style="text-align: center;">Insert Main Station Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>StationID:</label>
            <input type="text" name="station_id" value="<?php echo $station_id; ?>">
        </div>
        <div class="form-group">
            <label>ChallanID:</label>
            <input type="text" name="challan_id">
        </div>
        <div class="form-group">
            <label>ReceiverID:</label>
            <input type="text" name="receiver_id">
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

