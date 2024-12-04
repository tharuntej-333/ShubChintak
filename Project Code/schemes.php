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
$query = "SELECT scheme_id, scheme_name, sector, gender, state, income_eligibility FROM Schemes WHERE 1=1";
$params = [];
$types = '';

// Fetch user's profile details for filtering if they have a profile
if ($hasProfile) {
    $stmtProfile = $db->prepare("SELECT gender, state, income_eligibility FROM user WHERE user_id = ?");
    $stmtProfile->bind_param("i", $_SESSION['login_id']);
    $stmtProfile->execute();
    $profileResult = $stmtProfile->get_result()->fetch_assoc();
}

// Check for filter inputs and add to query
if (!empty($_GET['sector'])) {
    $query .= " AND sector LIKE ?";
    $params[] = '%' . $_GET['sector'] . '%';
    $types .= 's';
}
if (!empty($_GET['gender'])) {
    $query .= " AND gender = ?";
    $params[] = $_GET['gender'];
    $types .= 's';
} elseif ($hasProfile) {
    // If no gender filter is applied, use user's gender from profile
    $query .= " AND gender = ?";
    $params[] = $profileResult['gender'];
    $types .= 's';
}
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
// if (!empty($_GET['min_income_eligibility'])) {
//     $query .= " AND income_eligibility >= ?";
//     $params[] = floatval($_GET['min_income']);
//     $types .= 'd';
// } 
// elseif ($hasProfile) {
//     // If no minimum income filter is applied, use user's income from profile
//     $query .= " AND income_eligibility <= ?";
//     $params[] = floatval($profileResult['income_eligibility']);
//     $types .= 'd';
// }
if (!empty($_GET['max_income'])) {
    $query .= " AND income_eligibility <= ?";
    $params[] = floatval($_GET['max_income']);
    $types .= 'd';
}

// Prepare and execute the statement
$stmt = $db->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$schemes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Schemes</title>
    <link rel="stylesheet" href="schemes.css">
</head>

<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <div class="container">
        <a href="home.php" class="btn">Back to Home</a>
        <h1>Available Schemes</h1>

        <!-- Filter Form -->
        <form class="filter-form" method="GET">
            <!-- <label for="sector">Sector:</label> -->
            <select id="sector" name="sector">  
                <option value="Student">Student</option>
                <option value="Education">Education</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Business">Business</option>
                <option value="Agriculture">Agriculture</option>
                <option value="Social Welfare">Social Welfare</option>
            </select><br>
            <!-- <label for="gender">Gender:</label> -->
            <select id="gender" name="gender">
                <option value="">Gender Eligibility</option>
                <option value="Male" <?php echo isset($_GET['gender']) && $_GET['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo isset($_GET['gender']) && $_GET['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo isset($_GET['gender']) && $_GET['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                <option value="Both" <?php echo isset($_GET['gender']) && $_GET['gender'] === 'Both' ? 'selected' : ''; ?>>Both</option>
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
            <!-- <input type="number" id="min_income" name="min_income" placeholder="Min Income" value="<?php echo htmlspecialchars($_GET['min_income'] ?? ''); ?>"> -->
            <input type="number" id="max_income" name="max_income" placeholder="Max Income" value="<?php echo htmlspecialchars($_GET['max_income'] ?? ''); ?>">
            <button type="submit" id="filter_btn">Filter</button>
        </form>
        <!-- Schemes Table -->
        <table>
            <tr>
                <th>Scheme Name</th>
                <th>Sector</th>
                <th>Gender Eligibility</th>
                <th>State</th>
                <th>Income</th>
            </tr>
            <hr>
            <?php if (!empty($schemes)): ?>
                <?php foreach ($schemes as $scheme): ?>
                    <tr>
                        <td><a href="scheme_details.php?id=<?php echo $scheme['scheme_id']; ?>"><?php echo htmlspecialchars($scheme['scheme_name']); ?></a></td>
                        <td><?php echo htmlspecialchars($scheme['sector']); ?></td>
                        <td><?php echo htmlspecialchars($scheme['gender']); ?></td>
                        <td><?php echo htmlspecialchars($scheme['state']); ?></td>
                        <td><?php echo htmlspecialchars($scheme['income_eligibility']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No schemes found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>

</html>