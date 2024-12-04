<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Usually, the default XAMPP password is empty
$dbname = 'DBMSproj';
$port = 3306;

$conn = new mysqli($host, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scheme_id = $_POST['scheme_id'];
    $scheme_name = $_POST['scheme_name'];
    $description = $_POST['description'];
    $sector = $_POST['sector'];
    $gender = $_POST['gender'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $income = $_POST['income'];
    $birth_year = $_POST['birth_year'];
    $state = $_POST['state'];
    $link = $_POST['link'];

    // Prepare and execute SQL statement to update scheme data
    $stmt = $conn->prepare("UPDATE Schemes SET scheme_name = ?, description = ?, sector = ?, gender = ?, start_date = ?, end_date = ?, income = ?, birth_year = ?, state = ?, link = ? WHERE scheme_id = ?");
    $stmt->bind_param("ssssssddssi", $scheme_name, $description, $sector, $gender, $start_date, $end_date, $income, $birth_year, $state, $link, $scheme_id);

    if ($stmt->execute()) {
        echo "Scheme updated successfully.";
    } else {
        echo "Error updating scheme: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<br>
<br>
<a href="update_scheme.html">Return to Main Page</a>
