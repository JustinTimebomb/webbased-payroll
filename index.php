<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll System Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <img src="images/logo.png" alt="Quality Corrugated Box Logo">
            </div>
            <h1>Welcome to</h1>
            <h2>Web-based Payroll System</h2>
            <p>With Rule-based AI Integration for Quality Corrugated Box MFG. Corp.</p>
        </div>
        <div class="right-panel">
            <div class="form-container">
                <h2>Welcome Back!</h2>
                <?php if(isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="login" class="btn-login">Login Now</button>
                    <button type="button" class="btn-google">
                        <img src="https://www.google.com/favicon.ico" alt="Google">
                        Login with Google
                    </button>
                    <div class="form-footer">
                        <a href="register.php">Create a new account</a>
                        <a href="#">Forgot password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
