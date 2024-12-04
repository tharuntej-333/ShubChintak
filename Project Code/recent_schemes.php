<?php
session_start();
require_once 'db_connect.php';

// Get current date and date from one month ago
$current_date = date('Y-m-d');
$one_month_ago = date('Y-m-d', strtotime('-1 month'));

// Prepare SQL statement to fetch recent schemes
$sql = "SELECT * FROM Schemes WHERE start_date >= ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('s', $one_month_ago);
$stmt->execute();
$result = $stmt->get_result();

// Check for results
$schemes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schemes[] = $row;
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Schemes</title>
    <link rel="stylesheet" href="recent_schemes.css">
</head>
<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <div class="container">
        <h1>Recent Schemes</h1>
        <hr>
        <?php if (count($schemes) > 0): ?>
            <center>
                <table>
                    <thead>
                        <tr>
                            <th>Scheme Name</th>
                            <th>Description</th>
                            <th>Sector</th>
                            <th>Gender</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Income</th>
                            <th>Birth Year</th>
                            <th>State</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schemes as $scheme): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($scheme['scheme_name']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['description']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['sector']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['gender']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['end_date']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['income_eligibility']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['birth_year_eligibility']); ?></td>
                                <td><?php echo htmlspecialchars($scheme['state']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($scheme['link']); ?>" target="_blank">View Link</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </center>
        <?php else: ?>
            <p class="no-data">No recent schemes found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
