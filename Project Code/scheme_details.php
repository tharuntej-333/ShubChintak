<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['login_id'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "Scheme ID not provided.";
    exit;
}

$scheme_id = intval($_GET['id']);
$stmt = $db->prepare("
    SELECT s.*, o.organization_name 
    FROM schemes s 
    LEFT JOIN organization o ON s.organization_id = o.organization_id 
    WHERE s.scheme_id = ?
");
$stmt->bind_param("i", $scheme_id);
$stmt->execute();
$scheme = $stmt->get_result()->fetch_assoc();

if (!$scheme) {
    echo "Scheme not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($scheme['scheme_name']); ?> - Scheme Details</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .scheme-info { margin-top: 20px; }
        .back-btn { display: inline-block; padding: 10px 20px; background-color: #333; color: #fff; text-decoration: none; border-radius: 5px; }
        .back-btn:hover { background-color: #555; }
        .apply-btn { display: inline-block; padding: 10px 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .apply-btn:hover { background-color: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <a href="schemes.php" class="back-btn">Back to Schemes</a>
        <h1><?php echo htmlspecialchars($scheme['scheme_name']); ?></h1>
        <div class="scheme-info">
            <p><strong>Description:</strong> <?php echo htmlspecialchars($scheme['description']); ?></p>
            <p><strong>Sector:</strong> <?php echo htmlspecialchars($scheme['sector']); ?></p>
            <p><strong>Gender Eligibility:</strong> <?php echo htmlspecialchars($scheme['gender']); ?></p>
            <p><strong>Income Limit:</strong> <?php echo htmlspecialchars(string: $scheme['income_eligibility']); ?></p>
            <p><strong>Birth Year Requirement:</strong> <?php echo htmlspecialchars($scheme['birth_year_eligibility']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($scheme['state']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($scheme['start_date']); ?></p>
            <p><strong>End Date:</strong> <?php echo htmlspecialchars($scheme['end_date']); ?></p>
            <p><strong>Organization:</strong> <?php echo htmlspecialchars($scheme['organization_name'] ?? 'Not specified'); ?></p>
            <a href="<?php echo htmlspecialchars($scheme['link']); ?>" class="apply-btn" target="_blank">Apply for Scheme</a>
        </div>
    </div>
</body>
</html>
