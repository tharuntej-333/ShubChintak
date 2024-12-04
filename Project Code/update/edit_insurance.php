<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Insurance Policy</title>
    <link rel="stylesheet" href="style.css">
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
            padding-bottom: 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: left;
            margin-top: 100px;
            margin-bottom: 100px;
        }
    
        h1 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
    
        form {
            display: flex;
            flex-direction: column;
        }
    
        label {
            font-size: 1em;
            color: #333;
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
    </style>
</head>

<body>

    <div class="container">
        <h1>Edit Insurance Policy</h1>

        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "DBMSProj", "3306");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['insurance_id'])) {
            $insurance_id = $_GET['insurance_id'];

            // Fetch data based on insurance_id
            $stmt = $conn->prepare("SELECT * FROM Insurance WHERE insurance_id = ?");
            $stmt->bind_param("i", $insurance_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "<p style='color: red;'>Insurance policy not found.</p>";
            }

            $stmt->close();
        } else {
            echo "<p style='color: red;'>No Insurance ID provided.</p>";
        }

        $conn->close();
        ?>

        <?php if (isset($row)) : ?>
            <!-- Form to edit insurance policy details -->
            <form method="POST" action="update_insurance.php">
                <input type="hidden" name="insurance_id" value="<?php echo $row['insurance_id']; ?>">

                <label for="policy_name">Policy Name:</label>
                <input type="text" name="policy_name" id="policy_name" value="<?php echo $row['policy_name']; ?>" required>

                <label for="description">Description:</label>
                <textarea name="description" id="description"><?php echo $row['description']; ?></textarea>

                <label for="type">Type:</label>
                <input type="text" name="type" id="type" value="<?php echo $row['type']; ?>">

                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo $row['start_date']; ?>">

                <label for="duration">Duration (months):</label>
                <input type="number" name="duration" id="duration" value="<?php echo $row['duration']; ?>">

                <label for="income">Income Requirement:</label>
                <input type="decimal" name="income" id="income" value="<?php echo $row['income']; ?>">

                <label for="birth_year">Birth Year:</label>
                <input type="number" name="birth_year" id="birth_year" value="<?php echo $row['birth_year']; ?>">

                <label for="state">State:</label>
                <input type="text" name="state" id="state" value="<?php echo $row['state']; ?>">

                <label for="link">Link:</label>
                <input type="text" name="link" id="link" value="<?php echo $row['link']; ?>">

                <label for="premium">Premium:</label>
                <input type="decimal" name="premium" id="premium" value="<?php echo $row['premium']; ?>">

                <button type="submit" name="update">Apply Changes</button>
            </form>
        <?php endif; ?>
    </div>

</body>

</html>