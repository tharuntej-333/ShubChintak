<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "DBMSProj","3306");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['insurance_id'])) {
    $insurance_id = $_POST['insurance_id'];

    // Check if the record exists
    $check_stmt = $conn->prepare("SELECT * FROM Insurance WHERE insurance_id = ?");
    $check_stmt->bind_param("i", $insurance_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete the record
        $delete_stmt = $conn->prepare("DELETE FROM Insurance WHERE insurance_id = ?");
        $delete_stmt->bind_param("i", $insurance_id);

        if ($delete_stmt->execute()) {
            echo "<p style='color: green;'>Insurance policy deleted successfully.</p>";
        } else {
            echo "<p style='color: red;'>Error deleting insurance policy.</p>";
        }

        $delete_stmt->close();
    } else {
        echo "<p style='color: red;'>Insurance policy not found with ID: $insurance_id</p>";
    }

    $check_stmt->close();
} else {
    echo "<p style='color: red;'>No Insurance ID provided.</p>";
}

$conn->close();
?>

<a href="delete_insurance.html">Return to Main Page</a>
