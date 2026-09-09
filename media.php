<?php
session_start();
include 'config.php';
include 'db_init.php';

$current_page = 'media';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media - Prantik Boro</title>
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
            <a href="media.php" class="nav-link active">Media</a>
            <a href="contact.php" class="nav-link">Contact</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="nav-link">Profile</a>
                <a href="logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </nav>
        <button id="themeToggle" class="btn" aria-label="Toggle dark mode">Dark Mode</button>
    </header>

    <main>
        <section class="section">
            <h2>Media & Resources</h2>
            
            <div class="media-grid">
                <div class="media-card">
                    <i class="fab fa-google"></i>
                    <h3>Google</h3>
                    <p>Search engine and productivity tools</p>
                    <a href="https://www.google.com" target="_blank" class="btn secondary">Visit</a>
                </div>

                <div class="media-card">
                    <i class="fab fa-youtube"></i>
                    <h3>YouTube</h3>
                    <p>Video streaming and tutorials</p>
                    <a href="https://www.youtube.com" target="_blank" class="btn secondary">Visit</a>
                </div>

                <div class="media-card">
                    <i class="fab fa-facebook"></i>
                    <h3>Facebook</h3>
                    <p>Social networking platform</p>
                    <a href="https://www.facebook.com" target="_blank" class="btn secondary">Visit</a>
                </div>

                <div class="media-card">
                    <i class="fab fa-instagram"></i>
                    <h3>Instagram</h3>
                    <p>Photo and video sharing</p>
                    <a href="https://www.instagram.com" target="_blank" class="btn secondary">Visit</a>
                </div>

                <div class="media-card">
                    <i class="fab fa-twitter"></i>
                    <h3>Twitter</h3>
                    <p>Microblogging and news</p>
                    <a href="https://www.twitter.com" target="_blank" class="btn secondary">Visit</a>
                </div>

                <div class="media-card">
                    <i class="fab fa-github"></i>
                    <h3>GitHub</h3>
                    <p>Code repository and collaboration</p>
                    <a href="https://www.github.com" target="_blank" class="btn secondary">Visit</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <hr>
        <p>&copy; <span id="year"></span> Prantik Boro 2026. All rights reserved.</p>
    </footer>

    <script src="assets/main.js"></script>
</body>
</html>
