<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }
        .navbar a:hover {
            background-color: #45a049;
            color: white;
        }
        .dropdown {
            float: left;
            overflow: hidden;
        }
        .dropdown .dropbtn {
            font-size: 17px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 20px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
            cursor: pointer;
        }
        .navbar a, .dropdown .dropbtn {
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            z-index: 1;
        }
        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
            color: black;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        @media screen and (max-width: 600px) {
            .navbar a, .dropdown .dropbtn {
                display: block;
                text-align: left;
                width: 100%;
            }
            .dropdown-content {
                width: 100%;
            }
        }
        .navbar-heading {
            font-size: 24px;
            color: white;
            padding: 14px 20px;
            float: left;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <span class="navbar-heading">TRANSPORT DASHBOARD</span>
        <a href="billform.php">BILL</a>
        <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-caret-down"></i> ADD CUSTOMERS</button>
            <div class="dropdown-content">
                <a href="senderform.php">SENDER</a>
                <a href="recieverform.php">RECEIVER</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-caret-down"></i>CHALLAN</button>
            <div class="dropdown-content">
                <a href="challanform.php">NEW CHALLAN</a>
                <a href="stationform.php">NEW STATION</a>
                <a href="driverform.php">DRIVER</a>
                <a href="receivingbranchform.php">RECEIVER BRANCH</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-caret-down"></i>SHOW DATABASE</button>
            <div class="dropdown-content">
                <a href="showchallan.php">CHALLAN</a>
                <a href="showreceiver.php">RECEIVERS</a>
                <a href="sendershow.php">SENDERS</a>
                <a href="mainstationshow.php">MAIN STATIONS</a>
                <a href="showdriver.php">DRIVERS</a>
                <a href="receiverbranch.php">RECEIVER BRANCHS</a>
                <a href="showbill.php">BILLS</a>
            </div>
        </div>
    </div>
</body>
</html>
