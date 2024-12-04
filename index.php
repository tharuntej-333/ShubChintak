<?php
session_start();
require_once 'db_connect.php';

// Check if user is already logged in
if (isset($_SESSION['login_id'])) {
    $stmt = $db->prepare("SELECT user_id FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['login_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user has a profile, redirect to home, else to dashboard
    if ($result->num_rows > 0) {
        header('Location: home.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
} elseif (isset($_SESSION['admin_id'])) {
    header('Location: admin_dashboard.php');
    exit;
}


// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Regular User Login handling
    if (isset($_POST['login'])) {
        $username = $db->real_escape_string($_POST['username']);
        $password = $_POST['password'];

        $stmt = $db->prepare("SELECT login_id, password_hash FROM user_login WHERE login_username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['login_id'] = $user['login_id'];

                // Check if user has a profile
                $stmt = $db->prepare("SELECT user_id FROM user WHERE user_id = ?");
                $stmt->bind_param("i", $user['login_id']);
                $stmt->execute();
                $profile_result = $stmt->get_result();

                if ($profile_result->num_rows == 0) {
                    header('Location: dashboard.php');
                } else {
                    header('Location: home.php');
                }
                exit;
            }
        }
        $login_error = "Invalid username or password";
    }

    // Admin Login handling
   // Admin Login handling
elseif (isset($_POST['admin_login'])) {
    $username = $db->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT admin_id, password_hash FROM admin WHERE admin_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if admin exists
    if ($admin = $result->fetch_assoc()) {
        if ($password === $admin['password_hash']) { // Direct comparison
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['is_admin'] = true; // Set is_admin to true
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $login_error = "Invalid in admin credentials";
        }
    } else {
        $login_error = "Invalid out admin credentials";
    }
}



    // User Registration handling
    elseif (isset($_POST['register'])) {
        $username = $db->real_escape_string($_POST['username']);
        $email = $db->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if username or email already exists
        $stmt = $db->prepare("SELECT login_id FROM user_login WHERE login_username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            $register_error = "Username or email already exists.";
        } else {
            $stmt = $db->prepare("INSERT INTO user_login (login_username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                $_SESSION['login_id'] = $db->insert_id;
                header('Location: dashboard.php');
                exit;
            } else {
                $register_error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication - Insurance Scheme System</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <nav>
        <img id="web-logo" src="website_logo.png" alt="LOGO">
        <h1>Insurance Scheme System</h1>
    </nav>
    <main>
        <div class="container">
            
                <div id="user-registration" class="user-registration">
                    <h2>User Registration</h2>
                    <?php if (isset($register_error)) echo "<p class='error'>$register_error</p>"; ?>
                    <form method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" name="register">Register</button>
                    </form>
                </div>
                <div id="user-login" class="user-login">
                    <h2>User Login</h2>
                    <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
                    <form method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" name="login">Login</button>
                    </form>
                </div>
            
            
            <div id="admin-login" class="admin-login">
                <h2>Admin Login</h2>
                <form method="POST">
                    <input type="text" name="username" placeholder="Admin Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="admin_login">Admin Login</button>
                </form>
            </div>
        </div>
    </main>     
    
</body>

</html>