<?php
/**
 * Enhanced Database Connection Module
 * Provides secure database connection with error handling and utilities
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'prantik_website');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');

// Error handling
define('DB_ERROR_LOG', __DIR__ . '/logs/db_errors.log');

// Create logs directory if it doesn't exist
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

/**
 * Get Database Connection
 * Creates and returns a secure mysqli connection
 */
function getDBConnection() {
    // Create connection
    $conn = new mysqli(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME,
        DB_PORT
    );

    // Check connection
    if ($conn->connect_error) {
        logDatabaseError("Connection failed: " . $conn->connect_error);
        die("Database connection failed. Please contact administrator.");
    }

    // Set charset to UTF-8
    $conn->set_charset(DB_CHARSET);

    // Set timezone
    $conn->query("SET time_zone='+05:30'");

    return $conn;
}

/**
 * Log Database Errors
 */
function logDatabaseError($error) {
    $timestamp = date('Y-m-d H:i:s');
    $message = "[$timestamp] " . $error . "\n";
    error_log($message, 3, DB_ERROR_LOG);
}

/**
 * Execute Prepared Statement
 * Wrapper for executing prepared statements with error handling
 */
function executePrepared($conn, $sql, $types = '', $params = []) {
    try {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        return $stmt;
    } catch (Exception $e) {
        logDatabaseError($e->getMessage());
        return false;
    }
}

/**
 * Get Single Row
 * Fetches a single row as associative array
 */
function getRow($conn, $sql, $types = '', $params = []) {
    $stmt = executePrepared($conn, $sql, $types, $params);
    if (!$stmt) return false;

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return $row;
}

/**
 * Get All Rows
 * Fetches all rows as array
 */
function getAllRows($conn, $sql, $types = '', $params = []) {
    $stmt = executePrepared($conn, $sql, $types, $params);
    if (!$stmt) return [];

    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $rows;
}

/**
 * Insert Data
 * Executes INSERT statement and returns insert ID
 */
function insertData($conn, $sql, $types, $params) {
    $stmt = executePrepared($conn, $sql, $types, $params);
    if (!$stmt) return false;

    $insertId = $conn->insert_id;
    $stmt->close();

    return $insertId;
}

/**
 * Update Data
 * Executes UPDATE statement and returns affected rows
 */
function updateData($conn, $sql, $types, $params) {
    $stmt = executePrepared($conn, $sql, $types, $params);
    if (!$stmt) return false;

    $affectedRows = $conn->affected_rows;
    $stmt->close();

    return $affectedRows;
}

/**
 * Delete Data
 * Executes DELETE statement and returns affected rows
 */
function deleteData($conn, $sql, $types, $params) {
    $stmt = executePrepared($conn, $sql, $types, $params);
    if (!$stmt) return false;

    $affectedRows = $conn->affected_rows;
    $stmt->close();

    return $affectedRows;
}

/**
 * Get Database Statistics
 */
function getDatabaseStats($conn) {
    $stats = [];

    // Get table count and sizes
    $query = "SELECT 
                COUNT(*) as table_count,
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb
              FROM information_schema.tables 
              WHERE table_schema = ?";
    
    $row = getRow($conn, $query, 's', [$_GET['db'] ?? DB_NAME]);
    $stats['table_count'] = $row['table_count'] ?? 0;
    $stats['size_mb'] = $row['size_mb'] ?? 0;

    // Get users count
    $stats['users_count'] = getRow($conn, "SELECT COUNT(*) as count FROM users")['count'] ?? 0;

    // Get messages count
    $stats['messages_count'] = getRow($conn, "SELECT COUNT(*) as count FROM messages")['count'] ?? 0;

    // Get unread messages count
    $stats['unread_messages'] = getRow($conn, "SELECT COUNT(*) as count FROM messages WHERE is_read = FALSE")['count'] ?? 0;

    return $stats;
}

/**
 * Check Database Connection Health
 */
function checkDatabaseHealth($conn) {
    $health = [
        'connected' => true,
        'errors' => []
    ];

    // Test connection
    if (!$conn->ping()) {
        $health['connected'] = false;
        $health['errors'][] = "Database connection failed";
    }

    // Check if main tables exist
    $tables = ['users', 'messages', 'contacts'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows === 0) {
            $health['errors'][] = "Table '$table' does not exist";
        }
    }

    return $health;
}

// Create initial connection for backward compatibility
$conn = getDBConnection();
?>
