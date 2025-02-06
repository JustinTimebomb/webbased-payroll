<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

if(isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: index.php");
        exit();
    } else {
        $error = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll System Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <img src="images/logo.png" alt="Quality Logo">
            </div>
            <h1>Welcome to</h1>
            <h2>Web-based Payroll System</h2>
            <p>With Rule-based AI Integration for Quality Corrugated Box MFG. Corp.</p>
        </div>
        <div class="right-panel">
            <div class="form-container">
                <h2>Create Account</h2>
                <?php if(isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="register" class="btn-login">Create Account</button>
                    <div class="form-footer">
                        <p>Already have an account? <a href="index.php">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
