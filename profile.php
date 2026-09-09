<?php
session_start();
include 'config.php';
include 'db_init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$current_page = 'profile';

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, location = ?, bio = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $full_name, $location, $bio, $phone, $user_id);

    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
        $_SESSION['full_name'] = $full_name;
        $user['full_name'] = $full_name;
        $user['location'] = $location;
        $user['bio'] = $bio;
        $user['phone'] = $phone;
    } else {
        $error = "Failed to update profile.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Prantik Boro</title>
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
            <a href="about.php" class="nav-link">About</a>
            <a href="contact.php" class="nav-link">Contact</a>
            <a href="profile.php" class="nav-link active">Profile</a>
            <a href="logout.php" class="nav-link">Logout</a>
        </nav>
        <button id="themeToggle" class="btn" aria-label="Toggle dark mode">Dark Mode</button>
    </header>

    <main class="section">
        <h2>User Profile</h2>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-basic">
                    <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($user['location'] ?: 'Not specified'); ?></p>
                </div>
            </div>

            <form method="POST" class="form">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user['location'] ?: ''); ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?: ''); ?>">
                </div>
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($user['bio'] ?: ''); ?></textarea>
                </div>
                <button type="submit" class="btn primary">Update Profile</button>
            </form>

            <div class="profile-info">
                <h4>Account Information</h4>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
    </main>

    <footer class="footer">
        <hr>
        <p>&copy; <span id="year"></span> Prantik Boro 2026. All rights reserved.</p>
    </footer>

    <script src="assets/main.js"></script>
</body>
</html>
