<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch data from the challan table
$sql = "SELECT * FROM Challan";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Challan Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Challan Data</h2>
    <table>
        <tr>
            <th>ChallanID</th>
            <th>DriverID</th>
            <th>TruckNo</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ChallanID"] . "</td>";
                echo "<td>" . $row["DriverID"] . "</td>";
                echo "<td>" . $row["TruckNo"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data available</td></tr>";
        }
        ?>
    </table>
</body>
</html>
