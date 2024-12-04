<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['login_id'])) {
    header('Location: index.php');
    exit;
}

// First, check if user already has a profile
$stmt = $db->prepare("SELECT user_id FROM user WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['login_id']);
$stmt->execute();
$result = $stmt->get_result();

// If user has a profile, redirect to home
if ($result->num_rows > 0) {
    header('Location: home.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dob = $db->real_escape_string($_POST['dob']);
    $gender = $db->real_escape_string($_POST['gender']);
    $state = $db->real_escape_string($_POST['state']);
    $occupation = $db->real_escape_string($_POST['occupation']);
    $income = floatval($_POST['income']);
    $marital_status = $db->real_escape_string($_POST['marital_status']);

    // Insert user profile into the database
    $stmt = $db->prepare("INSERT INTO User (user_id, dob, gender, state, occupation, income, marital_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssds", $_SESSION['login_id'], $dob, $gender, $state, $occupation, $income, $marital_status);

    if ($stmt->execute()) {
        header('Location: home.php');
        exit;
    } else {
        $error = "Failed to create profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile - Insurance Scheme System</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;   
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        button {
            display: inline-block;
            background: #15803D;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #50A06E;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .skip-link {
            display: inline-block;
            margin-left: 10px;
            color: #333;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <div class="container">
        <h1>Create Your Profile</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div>
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <div>
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
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
            </div>

            <label for="occupation">Occupation:</label>
            <select id="occupation" name="occupation">
                <option value="Student">Student</option>
                <option value="Education">Education</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Business">Business</option>
                <option value="Agriculture">Agriculture</option>
                <option value="Social Welfare">Social Welfare</option>
            </select><br>

            <div>
                <label for="income">Annual Income (₹)</label>
                <input type="number" id="income" name="income" step="0.01" min="0" placeholder="Enter your annual income" required>
            </div>

            <div>
                <label for="marital_status">Marital Status</label>
                <select id="marital_status" name="marital_status" required>
                    <option value="">Select Marital Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>

            <button type="submit">Create Profile</button>
            <a href="home.php" class="skip-link">Skip for now</a>
        </form>
    </div>
</body>

</html>