<?php
session_start();
include 'config.php';
include 'db_init.php';

$current_page = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Prantik Boro</title>
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
            <a href="about.php" class="nav-link active">About</a>
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
            <h2>About Me</h2>
            <div class="about-content">
                <div class="about-text">
                    <h3>Web Design and Development</h3>
                    <br>
                    <p>Website design and development is the comprehensive process of planning, creating, and maintaining a website, combining visual aesthetics with technical functionality to establish an online presence. It is often divided into two main, yet intertwined, disciplines: web design (the look and user experience) and web development (the coding and technical construction).</p>
                    <br>
                    <h3>Key Aspects of Web Design (Front-End & UX)</h3>
                    <br>
                    <p>Web design focuses on the visual and user-experience aspects of a site:</p>
                    <ul>
                        <li><strong>UI/UX Design:</strong> Creating wireframes, prototypes, and user interfaces to ensure the site is intuitive, accessible, and engaging.</li>
                        <li><strong>Visual Aesthetics:</strong> Selecting color schemes, fonts, typography, and images that reflect brand identity.</li>
                        <li><strong>Layout and Structure:</strong> Designing the layout for responsiveness across different screen sizes and devices.</li>
                        <li><strong>Tools:</strong> Figma, Sketch, Adobe XD</li>
                    </ul>

                    <h4>Key Aspects of Web Development (Technical Construction)</h4>
                    <p>Web development turns designs into a functioning website, typically divided into front-end and back-end:</p>
                    <ul>
                        <li><strong>Front-End Development:</strong> HTML, CSS, and JavaScript for client-side interactions</li>
                        <li><strong>Back-End Development:</strong> Server-side logic, databases, and APIs</li>
                        <li><strong>Database Management:</strong> MySQL, MongoDB, PostgreSQL</li>
                        <li><strong>CMS Integration:</strong> WordPress, Drupal, custom solutions</li>
                    </ul>

                    <h4>The Development Process</h4>
                    <ol>
                        <li>Planning and Strategy</li>
                        <li>Design (UI/UX)</li>
                        <li>Development</li>
                        <li>Testing and Quality Assurance</li>
                        <li>Deployment and Maintenance</li>
                    </ol>

                    <h4>Why Design and Development Matter</h4>
                    <ul>
                        <li><strong>First Impressions:</strong> A professional design builds trust</li>
                        <li><strong>Functionality:</strong> Smooth operation and user interactions</li>
                        <li><strong>SEO:</strong> Better visibility in search engines</li>
                        <li><strong>Sales/Leads:</strong> Powerful marketing tool for revenue generation</li>
                    </ul>
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
