<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

// Fetch organizations
$orgs = [];
$result = $db->query("SELECT organization_id, organization_name FROM organization");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orgs[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $scheme_name = $db->real_escape_string($_POST['scheme_name']);
    $description = $db->real_escape_string($_POST['description']);
    $sector = $db->real_escape_string($_POST['sector']);
    $gender = $db->real_escape_string($_POST['gender']);
    $start_date = $db->real_escape_string($_POST['start_date']);
    $end_date = $db->real_escape_string($_POST['end_date']);
    $income_eligibility = $db->real_escape_string($_POST['income']);
    $birth_year_eligibility = $db->real_escape_string($_POST['birth_year_eligibility']);
    $state = $db->real_escape_string($_POST['state']);
    $link = $db->real_escape_string($_POST['link']);
    $organization_id = intval($_POST['organization_id']);

    // Validate inputs
    if ($organization_id <= 0) {
        $error_message = "Please select a valid organization.";
    } elseif (empty($income_eligibility) || !is_numeric($income_eligibility)) {
        $error_message = "Invalid income eligibility.";
    } elseif (empty($birth_year_eligibility) || !is_numeric($birth_year_eligibility)) {
        $error_message = "Invalid birth year eligibility.";
    } else {
        // Insert into database
        $query = "INSERT INTO schemes (scheme_name, description, sector, gender, start_date, end_date, income_eligibility, birth_year_eligibility, state, link, organization_id) 
                  VALUES ('$scheme_name', '$description', '$sector', '$gender', '$start_date', '$end_date', '$income_eligibility', '$birth_year_eligibility', '$state', '$link', '$organization_id')";
        
        if ($db->query($query)) {
            $success_message = "Scheme added successfully!";
        } else {
            $error_message = "Error: " . $db->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Scheme</title>
    <link rel="stylesheet" href="add_scheme.css">
</head>

<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <div class="container">
        <h1>Add New Scheme</h1>
        <?php if (isset($success_message)) echo "<p style='color: green;'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>
        <form action="add_scheme.php" method="POST">
            <label for="scheme_name">Scheme Name:</label>
            <input type="text" id="scheme_name" name="scheme_name" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="sector">Sector:</label>
            <select id="sector" name="sector">
                <option value="Student">Student</option>
                <option value="Education">Education</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Business">Business</option>
                <option value="Agriculture">Agriculture</option>
                <option value="Social Welfare">Social Welfare</option>
            </select><br>

            <label for="gender">Gender Eligibility:</label>
            <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
                <option value="Both">Both</option>
            </select><br>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date"><br>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date"><br>

            <label for="income">Income Eligibility:</label>
            <input type="number" step="0.01" id="income" name="income"><br>

            <label for="birth_year_eligibility">Birth Year:</label>
            <input type="number" id="birth_year_eligibility" name="birth_year_eligibility"><br>

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
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Delhi">Delhi</option>
                <option value="Puducherry">Puducherry</option>
            </select><br>

            <label for="link">More Info Link:</label>
            <input type="text" id="link" name="link"><br>

            <label for="organization_id">Select Organization:</label>
            <select id="organization_id" name="organization_id" required>
                <option value="">Select Organization</option>
                <?php foreach ($orgs as $org) : ?>
                    <option value="<?php echo $org['organization_id']; ?>"><?php echo $org['organization_name']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <button type="submit">Add Scheme</button>
        </form>
        <div class="buttons">
            <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
    </div>
</body>

</html>
