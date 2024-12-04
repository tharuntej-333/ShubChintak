<?php
session_start();
require_once 'db_connect.php';

// Assume user_id is stored in the session after user login
$user_id = $_SESSION['login_id'];

// Get the current date and date from one month ago
$current_date = date('Y-m-d');
$one_month_ago = date('Y-m-d', strtotime('-1 month'));

// Prepare SQL statement to fetch applicable schemes for the user
$sql = "SELECT * FROM Schemes 
        WHERE start_date >= ? 
        AND (state = (SELECT state FROM User WHERE user_id = ?) 
        OR sector = (SELECT occupation FROM User WHERE user_id = ?) 
        OR gender = (SELECT gender FROM User WHERE user_id = ?))";

$stmt = $db->prepare($sql);
$stmt->bind_param('siii', $one_month_ago, $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check for results
$schemes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schemes[] = $row;
    }
}

// Prepare SQL statement to fetch applicable insurance policies for the user
$sql = "SELECT * FROM Insurance 
        WHERE start_date >= ? 
        AND (state = (SELECT state FROM User WHERE user_id = ?) 
        OR type = (SELECT occupation FROM User WHERE user_id = ?) 
        OR (income >= (SELECT income FROM User WHERE user_id = ?) AND duration > 0))";

$stmt = $db->prepare($sql);
$stmt->bind_param('siii', $one_month_ago, $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check for results
$insurances = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $insurances[] = $row;
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicable Schemes and Insurance Policies</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 30px; /* Space between containers */
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.2em;
        }

        .notification {
            margin-top: 20px;
            padding: 15px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-align: left;
            transition: background-color 0.3s ease; /* Smooth background color change */
        }

        .notification:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        a {
            color: white; /* White link color */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Bold font for links */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        .no-data {
            text-align: center;
            color: #777;
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>New Applicable Schemes</h1>
        <?php if (count($schemes) > 0): ?>
            <?php foreach ($schemes as $scheme): ?>
                <div class="notification">
                    <a href="scheme_details.php?id=<?php echo $scheme['scheme_id']; ?>"><?php echo htmlspecialchars($scheme['scheme_name']); ?></a>
                    <br>
                    <em><?php echo htmlspecialchars($scheme['description']); ?></em><br>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-data">No new applicable schemes found.</p>
        <?php endif; ?>
    </div>

    <div class="container">
        <h1>New Applicable Insurance Policies</h1>
        <?php if (count($insurances) > 0): ?>
            <?php foreach ($insurances as $insurance): ?>
                <div class="notification">
                    <a href="insurance_details.php?id=<?php echo $insurance['insurance_id']; ?>"><?php echo htmlspecialchars($insurance['policy_name']); ?></a>
                    <br>
                    <em><?php echo htmlspecialchars($insurance['description']); ?></em><br>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-data">No new applicable insurance policies found.</p>
        <?php endif; ?>
    </div>

</body>

</html>
