<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS prantik_website";
$conn->query($sql);

// Select database
$conn->select_db("prantik_website");

// Create users table
$users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    location VARCHAR(100),
    bio TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Create messages table
$messages_table = "CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE
)";

// Create contacts table
$contacts_table = "CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    contact_name VARCHAR(100),
    contact_type VARCHAR(50),
    contact_value VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
)";

$conn->query($users_table);
$conn->query($messages_table);
$conn->query($contacts_table);

// Insert sample user if not exists
$sample_user = "INSERT IGNORE INTO users (username, email, password, full_name, location, bio, phone) 
                VALUES ('prantik', 'prantikboro369@gmail.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "', 
                'Prantik Boro', 'Guwahati, Assam', 'Web developer with a passion for creating beautiful and functional websites.', '8474831319')";
$conn->query($sample_user);
?>
