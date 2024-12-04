<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['login_id'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Insurance Scheme System</title>
    <link rel="stylesheet" href="home.css"> 
</head>
<body>
    <nav>
        <div class="nav-one">
            <img id="web-logo" src="website_logo.png" alt="LOGO">
            <h1>Insurance Scheme System</h1>
        </div>
        <div class="logout-btn">
            <a href="logout.php" style=" color:black; text-decoration: none;">Logout</a>
        </div>    
    </nav>
    <main>
        <div class="container">
            <center>
            <h1>Welcome to the Insurance Scheme System</h1>
            </center>  
            <hr>
            <div class="options">
                <a href="schemes.php" class="option-btn" id="i1"><i>View Schemes</i></a>
                <a href="insurance.php" class="option-btn" id="i2"><i>View Insurance Plans</i></a>
                <a href="recent_schemes.php" class ="option-btn" id="i3"><i>Recent Schemes</i></a>
                <a href="recent_insurance.php" class ="option-btn" id="i4"><i>Recent Insurance</i></a>
                <a href="notification.php" class ="option-btn" id="i5"><i>Notification</i></a>
                <a href="dashboard.php" class="option-btn" id="i6"><i>User Dashboard</i></a>
            </div>
        </div>
    </main>
    
</body>
</html>
