<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Insurance Scheme System</title>
    <link rel="stylesheet" href="admin_dashboard.css">
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
            <h1>Admin Dashboard</h1>
            
            <!-- Insertion Section -->
            <div class="admin-section">
                <h2>Insertion</h2>
                <div class="admin-options">
                    <a href="add_scheme.php" class="admin-btn">Add New Scheme</a>
                    <a href="add_insurance.php" class="admin-btn">Add New Insurance Plan</a>
                </div>
            </div>

            <!-- Updation Section -->
            <div class="admin-section">
                <h2>Updation</h2>
                <div class="admin-options">
                    <a href="update/update_scheme.html" class="admin-btn">Update Scheme</a>
                    <a href="update/update_insurance.html" class="admin-btn">Update Insurance Plan</a>
                </div>
            </div>

            <!-- Deletion Section -->
            <div class="admin-section">
                <h2>Deletion</h2>
                <div class="admin-options">
                    <a href="delete/delete_scheme.html" class="admin-btn">Delete Scheme</a>
                    <a href="delete/delete_insurance.html" class="admin-btn">Delete Insurance Plan</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
