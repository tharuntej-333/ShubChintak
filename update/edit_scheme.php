<?php
$host = 'localhost';
$username = 'root';
$password = 'Rohit213$'; // Usually, the default XAMPP password is empty
$dbname = 'project2';
$port = 3307;

$conn = new mysqli($host, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if scheme_id is set
if (isset($_POST['scheme_id'])) {
    $scheme_id = $_POST['scheme_id'];

    // Prepare and execute SQL statement to fetch scheme data
    $stmt = $conn->prepare("SELECT * FROM Schemes WHERE scheme_id = ?");
    $stmt->bind_param("i", $scheme_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the scheme details
    if ($result->num_rows > 0) {
        $scheme = $result->fetch_assoc();
    } else {
        echo "No scheme found with that ID.";
        exit;
    }
} else {
    echo "No scheme ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Scheme</title>
    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    margin: 0;
}

.container {
    width: 100%;
    max-width: 500px;
    background: white;
    padding: 30px;
    padding-bottom: 50px; /* Add extra bottom padding for spaciousness */
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    text-align: left;
    margin-top: 100px; /* Start the container 100px below the top */
    margin-bottom: 100px; /* Add 100px space after the form */
}

h1 {
    font-size: 1.8em;
    color: #333; /* Ensure the title color is visible */
    margin-bottom: 20px;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 1em;
    color: #333; /* Set label color to ensure visibility */
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
input[type="date"],
input[type="decimal"],
select,
textarea {
    padding: 10px;
    font-size: 1em;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 20px;
    width: 100%;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

button {
    padding: 12px;
    background-color: #007bff;
    color: white;
    font-size: 1em;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
}

button:hover {
    background-color: #0056b3;
}

button:focus {
    outline: none;
    background-color: #0056b3;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Additional responsive adjustments */
@media (max-width: 500px) {
    .container {
        padding: 20px;
        padding-bottom: 40px; /* Adjust padding-bottom for mobile */
        margin-bottom: 80px; /* Adjust margin-bottom for mobile */
    }

    h1 {
        font-size: 1.5em;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Scheme</h1>
        <form action="update_scheme.php" method="POST">
            <input type="hidden" name="scheme_id" value="<?php echo $scheme['scheme_id']; ?>">

            <label for="scheme_name">Scheme Name:</label>
            <input type="text" name="scheme_name" value="<?php echo htmlspecialchars($scheme['scheme_name']); ?>" required>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($scheme['description']); ?>">

            <label for="sector">Sector:</label>
            <input type="text" name="sector" value="<?php echo htmlspecialchars($scheme['sector']); ?>">

            <label for="gender">Gender:</label>
            <select name="gender">
                <option value="Male" <?php echo ($scheme['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($scheme['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($scheme['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                <option value="Both" <?php echo ($scheme['gender'] == 'Both') ? 'selected' : ''; ?>>Both</option>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="<?php echo $scheme['start_date']; ?>">

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="<?php echo $scheme['end_date']; ?>">

            <label for="income_eligibility">Income:</label>
            <input type="decimal" name="income_eligibility" value="<?php echo $scheme['income_eligibility']; ?>">

            <label for="birth_year_eligibility">Birth Year:</label>
            <input type="number" name="birth_year_eligibility" value="<?php echo $scheme['birth_year_eligibility']; ?>">

            <label for="state">State:</label>
            <input type="text" name="state" value="<?php echo htmlspecialchars($scheme['state']); ?>">

            <label for="link">Link:</label>
            <input type="text" name="link" value="<?php echo htmlspecialchars($scheme['link']); ?>">

            <button type="submit">Apply Changes</button>
        </form>
    </div>
</body>
</html>
