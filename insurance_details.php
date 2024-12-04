<?php
session_start();
require_once 'db_connect.php'; // Include your database connection file

if (!isset($_SESSION['login_id'])) {
    header('Location: index.php'); // Redirect to login if user is not authenticated
    exit;
}

// Fetch the insurance plan details
if (isset($_GET['id'])) {
    $plan_id = (int)$_GET['id'];
    $stmt = $db->prepare("SELECT * FROM insurance WHERE insurance_id = ?");
    $stmt->bind_param("i", $plan_id);
    $stmt->execute();
    $insurance_plan = $stmt->get_result()->fetch_assoc();

    if (!$insurance_plan) {
        echo "Insurance plan not found.";
        exit;
    }
} else {
    echo "No insurance plan selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($insurance_plan['policy_name']); ?> - Insurance Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .back-btn {
            display: inline-block;
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="insurance.php" class="back-btn">Back to Insurance Plans</a>
        <h1><?php echo htmlspecialchars($insurance_plan['policy_name']); ?></h1>
        <p><strong>Type:</strong> <?php echo htmlspecialchars($insurance_plan['type']); ?></p>
        <p><strong>Coverage:</strong> $<?php echo number_format($insurance_plan['income']); ?></p>
        <p><strong>Premium:</strong> $<?php echo number_format($insurance_plan['premium']); ?> per month</p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($insurance_plan['description'])); ?></p>
        <p><strong>State:</strong> <?php echo htmlspecialchars($insurance_plan['state']); ?></p>
        <p><strong>Link:</strong> <a href="<?php echo htmlspecialchars($insurance_plan['link']); ?>" target="_blank">More Info</a></p>
    </div>
</body>

</html>
