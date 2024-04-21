<?php
require_once "conn.php";
require_once "navbar.php";

// Fetch data from the bill table
$sql = "SELECT * FROM Bill";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Bill Data</title>
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
    <h2 style="text-align: center;">Bill Data</h2>
    <table>
        <tr>
            <th>BillNo</th>
            <th>ReceivingBranchID</th>
            <th>SenderID</th>
            <th>ReceiverID</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["BillNo"] . "</td>";
                echo "<td>" . $row["ReceivingBranchID"] . "</td>";
                echo "<td>" . $row["SenderID"] . "</td>";
                echo "<td>" . $row["ReceiverID"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data available</td></tr>";
        }
        ?>
    </table>
</body>
</html>
