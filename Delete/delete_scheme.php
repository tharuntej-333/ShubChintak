<?php
// Database connection
$conn = new mysqli("localhost", "root", "Rohit213$", "project2", "3307");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['scheme_id'])) {
    $scheme_id = $_POST['scheme_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete records from schemeavailability
        $delete_availability = $conn->prepare("DELETE FROM schemeavailability WHERE scheme_id = ?");
        $delete_availability->bind_param("i", $scheme_id);
        $delete_availability->execute();

        // Delete records from schemeproviders
        $delete_providers = $conn->prepare("DELETE FROM schemeproviders WHERE scheme_id = ?");
        $delete_providers->bind_param("i", $scheme_id);
        $delete_providers->execute();

        // Delete the main record from schemes
        $delete_scheme = $conn->prepare("DELETE FROM schemes WHERE scheme_id = ?");
        $delete_scheme->bind_param("i", $scheme_id);
        $delete_scheme->execute();

        // Commit the transaction
        $conn->commit();
        echo "<p style='color: green;'>Scheme and all related records deleted successfully.</p>";
    } catch (mysqli_sql_exception $e) {
        // Rollback transaction in case of an error
        $conn->rollback();
        echo "<p style='color: red;'>Error deleting scheme: " . $e->getMessage() . "</p>";
    }

    // Close the prepared statements
    $delete_availability->close();
    $delete_providers->close();
    $delete_scheme->close();
} else {
    echo "<p style='color: red;'>No Scheme ID provided.</p>";
}

// Close the database connection
$conn->close();
?>
