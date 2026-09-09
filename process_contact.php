<?php
// Prevent direct access
if (!isset($_SERVER['HTTP_REFERER'])) {
    die("Invalid request");
}

session_start();
include 'config.php';
include 'db_init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit();
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Server-side validation
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: index.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: index.php");
    exit();
}

// Insert message into database
$stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    $_SESSION['success'] = "Message sent successfully! I'll get back to you soon.";
} else {
    $_SESSION['error'] = "Failed to send message. Please try again.";
}

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>
