<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

// $orgs = [];
// $result = $db->query("SELECT org_id, org_name FROM organization");
// if ($result) {
//     while ($row = $result->fetch_assoc()) {
//         $orgs[] = $row; // Store each organization in an array
//     }
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $policy_name = $db->real_escape_string(trim($_POST['policy_name']));
    $description = $db->real_escape_string(trim($_POST['description']));
    $type = $db->real_escape_string(trim($_POST['type']));
    $start_date = $db->real_escape_string(trim($_POST['start_date']));
    $duration = intval($_POST['duration']);
    $income = floatval($_POST['income']);
    $birth_year = intval($_POST['birth_year']);
    $state = $db->real_escape_string(trim($_POST['state']));
    $link = $db->real_escape_string(trim($_POST['link']));
    $premium = floatval($_POST['premium']);
    // $org_id = intval($_POST['org_id']);

    // Validate inputs (you can expand this as needed)
    if (empty($policy_name) || empty($description) || empty($type) || empty($start_date) || empty($state)) {
        $error_message = "Please fill in all required fields.";
    } elseif (!is_numeric($duration) || $duration <= 0) {
        $error_message = "Duration must be a positive number.";
    } elseif (!is_numeric($income) || $income < 0) {
        $error_message = "Income must be a non-negative number.";
    } elseif (!is_numeric($birth_year) || $birth_year < 1900 || $birth_year > date("Y")) {
        $error_message = "Please enter a valid birth year.";
    } elseif (!is_numeric($premium) || $premium < 0) {
        $error_message = "Premium must be a non-negative number.";
    } else {
        $stmt = $db->prepare("INSERT INTO Insurance (policy_name, description, type, start_date, duration, income, birth_year, state, link, premium) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdisdssd", $policy_name, $description, $type, $start_date, $duration, $income, $birth_year, $state, $link, $premium);

        if ($stmt->execute()) {
            $success_message = "Insurance plan added successfully!";
        } else {
            $error_message = "Failed to add insurance plan. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Insurance Plan - Insurance Scheme System</title>
    <link rel="stylesheet" href="add_insurance.css">
</head>
<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <div class="container">
        <h1>Add New Insurance Plan</h1>
        <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
        <?php if (isset($success_message)) echo "<p class='success'>$success_message</p>"; ?>
        <form method="POST">
            <label for="policy_name">Policy Name:</label>
            <input type="text" name="policy_name" placeholder="Insurance Policy Name" required>

            <label for="description">Description:</label>
            <textarea name="description" placeholder="Description" required></textarea>
            
            <label for="type">Type of Insurance:</label>
            <select id="type" name="type" required>
                <option value="">Select Insurance Type</option>
                <option value="Life Insurance">Life Insurance</option>
                <option value="Health Insurance">Health Insurance</option>
                <option value="Motor Insurance">Motor Insurance</option>
                <option value="Home Insurance">Home Insurance</option>
                <option value="Travel Insurance">Travel Insurance</option>
                <option value="Critical Illness Insurance">Critical Illness Insurance</option>
                <option value="Personal Accident Insurance">Personal Accident Insurance</option>
                <option value="Education Insurance">Education Insurance</option>
                <option value="Term Insurance">Term Insurance</option>
                <option value="ULIP (Unit Linked Insurance Plan)">ULIP (Unit Linked Insurance Plan)</option>
                <option value="Retirement Insurance">Retirement Insurance</option>
                <option value="Group Insurance">Group Insurance</option>
            </select>
            <input type="date" name="start_date" required>
            <label for="duration">Duration (months):</label>
            <select id="duration" name="duration" required>
                <option value="">Select Duration</option>
                <option value="6">6 months</option>
                <option value="12">12 months</option>
                <option value="18">18 months</option>
                <option value="24">24 months</option>
                <option value="30">30 months</option>
                <option value="36">36 months</option>
                <option value="42">42 months</option>
                <option value="48">48 months</option>
            </select>
            <input type="number" step="0.01" name="income" placeholder="Income Eligibility" required>
            <input type="number" name="birth_year" placeholder="Birth Year" min="1900" max="<?= date('Y') ?>" required>
            <label for="state">State:</label>
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
                <option value="Union Territories">Union Territories</option>
            </select>
            <input type="text" name="link" placeholder="Link to More Information" required>
            <input type="number" step="0.01" name="premium" placeholder="Premium Amount" required>
            <button type="submit">Add Insurance Plan</button>
        </form>
        <div class="buttons">
            <a class="back-btn" href="dashboard.php">Back to Dashboard</a>
            <a class="logout-btn" href="logout.php">Logout</a>
        </div>
        
    </div>
</body>
</html>
