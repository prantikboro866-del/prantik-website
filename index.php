<?php
session_start();
include 'config.php';

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

// Initialize database
include 'db_init.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : '';

// Get current page for nav highlighting
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prantik Boro - Portfolio</title>
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
            <a href="index.php" class="nav-link <?php echo $current_page === 'index' ? 'active' : ''; ?>">Home</a>
            <a href="about.php" class="nav-link <?php echo $current_page === 'about' ? 'active' : ''; ?>">About</a>
            <a href="media.php" class="nav-link <?php echo $current_page === 'media' ? 'active' : ''; ?>">Media</a>
            <a href="contact.php" class="nav-link <?php echo $current_page === 'contact' ? 'active' : ''; ?>">Contact</a>
            <?php if ($is_logged_in): ?>
                <a href="profile.php" class="nav-link <?php echo $current_page === 'profile' ? 'active' : ''; ?>">Profile</a>
                <a href="logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-link <?php echo $current_page === 'login' ? 'active' : ''; ?>">Login</a>
            <?php endif; ?>
        </nav>
        <button id="themeToggle" class="btn" aria-label="Toggle dark mode">Dark Mode</button>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to My Portfolio</h1>
                <h3>I'm <span class="typing-text" data-words='["Web Developer","Freelancer","Graphics Designer","Ecommerce"]'></span></h3>
                <p>Building beautiful, functional, and user-friendly websites</p>
                <div class="hero-buttons">
                    <a href="contact.php" class="btn primary">Contact Me</a>
                    <a href="about.php" class="btn secondary">Learn More</a>
                </div>
            </div>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
                <a href="https://www.github.com" target="_blank"><i class="fab fa-github"></i></a>
                <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://wa.me/8474831319" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
        </section>

        <section id="services" class="section">
            <h2>Services</h2>
            <div class="card-grid">
                <article class="card">
                    <i class="fas fa-code"></i>
                    <h3>Web Development</h3>
                    <p>Full-stack web development with modern technologies and frameworks</p>
                </article>
                <article class="card">
                    <i class="fas fa-paint-brush"></i>
                    <h3>UI/UX Design</h3>
                    <p>Creative and responsive design that enhances user experience</p>
                </article>
                <article class="card">
                    <i class="fas fa-mobile-alt"></i>
                    <h3>Responsive Design</h3>
                    <p>Mobile-first approach ensuring perfect display on all devices</p>
                </article>
            </div>
        </section>

        <section id="contact" class="section">
            <h2>Get In Touch</h2>
            <form id="contactForm" class="form" method="POST" action="process_contact.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn primary">Send Message</button>
                <p id="formMessage" class="form-message"></p>
            </form>
        </section>
    </main>

    <?php if ($success): ?>
        <div class="alert alert-success alert-bottom" role="status"><?php echo htmlspecialchars($success); ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-error alert-bottom" role="alert"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <footer class="footer">
        <hr>
        <p>&copy; <span id="year"></span> Prantik Boro 2026. All rights reserved 2026.</p>
    </footer>

    <script src="assets/main.js"></script>
</body>
</html>
