<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "DBMSProj","3306");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['update'])) {
    $insurance_id = $_POST['insurance_id'];
    $policy_name = $_POST['policy_name'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $start_date = $_POST['start_date'];
    $duration = $_POST['duration'];
    $income = $_POST['income'];
    $birth_year = $_POST['birth_year'];
    $state = $_POST['state'];
    $link = $_POST['link'];
    $premium = $_POST['premium'];

    // Update query
    $stmt = $conn->prepare("UPDATE Insurance SET policy_name = ?, description = ?, type = ?, start_date = ?, duration = ?, income = ?, birth_year = ?, state = ?, link = ?, premium = ? WHERE insurance_id = ?");
    $stmt->bind_param("ssssisissdi", $policy_name, $description, $type, $start_date, $duration, $income, $birth_year, $state, $link, $premium, $insurance_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Insurance policy updated successfully.</p>";
    } else {
        echo "<p style='color: red;'>Failed to update insurance policy.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
<br>
<br>
<a href="update_insurance.html">Return to Main Page</a>
