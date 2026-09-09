<?php
session_start();
include 'config.php';
include 'db_init.php';

$current_page = 'login';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, email, password, full_name FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = $user['full_name'];
                header("Location: profile.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Prantik Boro</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="brand">
            <a href="index.php">
                <i class="fas fa-atom"></i>
                <span>Prantik</span>
            </a>
        </div>
        <nav class="nav">
            <a href="index.php" class="nav-link">Home</a>
            <a href="register.php" class="nav-link">Register</a>
        </nav>
        <button id="themeToggle" class="btn" aria-label="Toggle dark mode">Dark Mode</button>
    </header>

    <main class="auth-container">
        <div class="auth-card">
            <h2>Login</h2>
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn primary">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>

            <!-- <p style="font-size: 0.9rem; margin-top: 1rem;">Demo: prantikboro369@gmail.com / password123</p> -->
        </div>
    </main>

    <footer class="footer">
        <hr>
        <p>&copy; <span id="year"></span> Prantik Boro 2026. All rights reserved.</p>
    </footer>

    <script src="assets/main.js"></script>
</body>
</html>
