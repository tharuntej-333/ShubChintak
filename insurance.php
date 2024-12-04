<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['login_id'])) {
    header('Location: index.php');
    exit;
}

// First, check if the user already has a profile
$stmt = $db->prepare("SELECT user_id FROM user WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['login_id']);
$stmt->execute();
$result = $stmt->get_result();

// Check if user has a profile
$hasProfile = $result->num_rows > 0;

// Initialize query and parameters for filtering
$query = "SELECT insurance_id, policy_name, type, duration, state, income FROM insurance WHERE 1=1";
$params = [];
$types = '';

// Fetch user's profile details for filtering if they have a profile
if ($hasProfile) {
    $stmtProfile = $db->prepare("SELECT state, income FROM user WHERE user_id = ?");
    $stmtProfile->bind_param("i", $_SESSION['login_id']);
    $stmtProfile->execute();
    $profileResult = $stmtProfile->get_result()->fetch_assoc();
}

// Check for filter inputs and add to query
if (!empty($_GET['type'])) {
    $query .= " AND type LIKE ?";
    $params[] = '%' . $_GET['type'] . '%';
    $types .= 's';
}
// if (!empty($_GET['gender'])) {
//     $query .= " AND gender = ?";
//     $params[] = $_GET['gender'];
//     $types .= 's';
// } elseif ($hasProfile) {
//     // If no gender filter is applied, use user's gender from profile
//     $query .= " AND gender = ?";
//     $params[] = $profileResult['gender'];
//     $types .= 's';
// }
if (!empty($_GET['state'])) {
    $query .= " AND state LIKE ?";
    $params[] = '%' . $_GET['state'] . '%';
    $types .= 's';
} elseif ($hasProfile) {
    // If no state filter is applied, use user's state from profile
    $query .= " AND state = ?";
    $params[] = $profileResult['state'];
    $types .= 's';
}
if (!empty($_GET['min_income'])) {
    $query .= " AND income >= ?";
    $params[] = floatval($_GET['min_income']);
    $types .= 'd';
} elseif ($hasProfile) {
    // If no minimum income filter is applied, use user's income from profile
    $query .= " AND income >= ?";
    $params[] = floatval($profileResult['income']);
    $types .= 'd';
}
if (!empty($_GET['max_income'])) {
    $query .= " AND income <= ?";
    $params[] = floatval($_GET['max_income']);
    $types .= 'd';
}

// Prepare and execute the statement
$stmt = $db->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$insurance = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Policy</title>
    <link rel="stylesheet" href="insurance.css">
</head>
<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <div class="container">
        <a href="home.php" class="btn">Back to Home</a>
        <h1>Available Policy</h1>

        <!-- Filter Form -->
        <form class="filter-form" method="GET">
            <input type="text" id="type" name="type" placeholder="Type" value="<?php echo htmlspecialchars($_GET['sector'] ?? ''); ?>">
            <select id="duration" name="duration">
                <option value="">Duration</option>
                <option value="6" <?php echo isset($_GET['duration']) && $_GET['duration'] === '6' ? 'selected' : ''; ?>>6</option>
                <option value="12" <?php echo isset($_GET['duration']) && $_GET['duration'] === '12' ? 'selected' : ''; ?>>12</option>
                <option value="24" <?php echo isset($_GET['duration']) && $_GET['duration'] === '24' ? 'selected' : ''; ?>>24</option>
                <option value="36" <?php echo isset($_GET['duration']) && $_GET['duration'] === '36' ? 'selected' : ''; ?>>36</option>
            </select>
            <!-- <label for="state">State:</label> -->
            <select id="state" name="state" required>
                <option value="">Select State</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Delhi">Delhi</option>
                <option value="Puducherry">Puducherry</option>
            </select><br>
            <input type="number" id="min_income" name="min_income" placeholder="Min Income" value="<?php echo htmlspecialchars($_GET['min_income'] ?? ''); ?>">
            <input type="number" id="max_income" name="max_income" placeholder="Max Income" value="<?php echo htmlspecialchars($_GET['max_income'] ?? ''); ?>">
            <button type="submit" id="filter_btn">Filter</button>
        </form>
        <hr>
        <!-- insurance Table -->
        <table>
            <tr>
                <th>policy Name</th>
                <th>type</th>
                <!-- <th>Gender Eligibility</th> -->
                <th>State</th>
                <th>Income</th>
            </tr>
            <?php if (!empty($insurance)): ?>
                <?php foreach ($insurance as $insu): ?>
                    <tr>
                        <td><a href="insurance_details.php?id=<?php echo $insu['insurance_id']; ?>"><?php echo htmlspecialchars($insu['policy_name']); ?></a></td>
                        <td><?php echo htmlspecialchars($insu['type']); ?></td>
                        <!-- <td><?php echo htmlspecialchars($insu['gender']); ?></td> -->
                        <td><?php echo htmlspecialchars($insu['state']); ?></td>
                        <td><?php echo htmlspecialchars($insu['income']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No insurance found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>



