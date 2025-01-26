<?php
session_start();
require_once 'db_connect.php';

// Get current date and date from one month ago
$current_date = date('Y-m-d');
$one_month_ago = date('Y-m-d', strtotime('-1 month'));

// Prepare SQL statement to fetch recent insurance policies
$sql = "SELECT * FROM Insurance WHERE start_date >= ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('s', $one_month_ago);
$stmt->execute();
$result = $stmt->get_result();

// Check for results
$insurance_policies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $insurance_policies[] = $row;
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Insurance Policies</title>
    <link rel="stylesheet" href="recent_insurance.css">
    <style>
        
    </style>
</head>
<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <div class="container">
        <h1>Recent Insurance Policies</h1>
        <hr>
        <?php if (count($insurance_policies) > 0): ?>
            <center>
                <table>
                    <thead>
                        <tr>
                            <th>Policy Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>Duration (months)</th>
                            <th>Income</th>
                            <th>Birth Year</th>
                            <th>State</th>
                            <th>Link</th>
                            <th>Premium</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($insurance_policies as $policy): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($policy['policy_name']); ?></td>
                                <td><?php echo htmlspecialchars($policy['description']); ?></td>
                                <td><?php echo htmlspecialchars($policy['type']); ?></td>
                                <td><?php echo htmlspecialchars($policy['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($policy['duration']); ?></td>
                                <td><?php echo htmlspecialchars($policy['income']); ?></td>
                                <td><?php echo htmlspecialchars($policy['birth_year']); ?></td>
                                <td><?php echo htmlspecialchars($policy['state']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($policy['link']); ?>" target="_blank">View Link</a></td>
                                <td><?php echo htmlspecialchars($policy['premium']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </center>
        <?php else: ?>
            <p class="no-data">No recent insurance policies found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
