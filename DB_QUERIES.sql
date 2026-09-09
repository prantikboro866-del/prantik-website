-- ============================================================================
-- USEFUL DATABASE QUERIES FOR ANALYSIS AND MANAGEMENT
-- ============================================================================
-- Common queries for database management and analysis
-- Copy and paste these into phpMyAdmin or your database client
-- ============================================================================

-- ============================================================================
-- USERS ANALYSIS QUERIES
-- ============================================================================

-- Get total users count
SELECT COUNT(*) as total_users FROM users;

-- Get users with their recent activity
SELECT 
    id, 
    username, 
    email, 
    full_name,
    created_at,
    last_login,
    DATEDIFF(NOW(), created_at) as days_since_join
FROM users
ORDER BY created_at DESC;

-- Get active vs inactive users
SELECT 
    is_active,
    COUNT(*) as count
FROM users
GROUP BY is_active;

-- Get users registered in the last 7 days
SELECT 
    id,
    username,
    email,
    full_name,
    created_at
FROM users
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
ORDER BY created_at DESC;

-- Get users by registration month
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    COUNT(*) as new_users
FROM users
GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ORDER BY month DESC;

-- Find users without profile completion
SELECT 
    id,
    username,
    email,
    full_name,
    location,
    bio,
    phone
FROM users
WHERE full_name IS NULL OR location IS NULL OR bio IS NULL OR phone IS NULL
ORDER BY created_at DESC;

-- ============================================================================
-- MESSAGES ANALYSIS QUERIES
-- ============================================================================

-- Get total messages count
SELECT COUNT(*) as total_messages FROM messages;

-- Get message statistics
SELECT 
    COUNT(*) as total_messages,
    SUM(CASE WHEN is_read = TRUE THEN 1 ELSE 0 END) as read_messages,
    SUM(CASE WHEN is_read = FALSE THEN 1 ELSE 0 END) as unread_messages
FROM messages;

-- Get unread messages
SELECT 
    id,
    name,
    email,
    subject,
    created_at
FROM messages
WHERE is_read = FALSE
ORDER BY created_at DESC;

-- Get all messages with read/unread status
SELECT 
    id,
    name,
    email,
    subject,
    created_at,
    CASE WHEN is_read = TRUE THEN 'Read' ELSE 'Unread' END as status
FROM messages
ORDER BY created_at DESC;

-- Get messages from last 30 days
SELECT 
    id,
    name,
    email,
    subject,
    created_at,
    DATEDIFF(NOW(), created_at) as days_old
FROM messages
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
ORDER BY created_at DESC;

-- Get messages by sender (frequency analysis)
SELECT 
    email,
    COUNT(*) as message_count,
    MAX(created_at) as last_message
FROM messages
GROUP BY email
ORDER BY message_count DESC;

-- Get messages by date
SELECT 
    DATE(created_at) as message_date,
    COUNT(*) as count
FROM messages
GROUP BY DATE(created_at)
ORDER BY message_date DESC;

-- Mark all unread messages as read
-- UPDATE messages SET is_read = TRUE WHERE is_read = FALSE;

-- Delete old messages (older than 90 days)
-- DELETE FROM messages WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- ============================================================================
-- CONTACTS ANALYSIS QUERIES
-- ============================================================================

-- Get all user contacts
SELECT 
    c.id,
    u.username,
    c.contact_name,
    c.contact_type,
    c.contact_value,
    c.created_at
FROM contacts c
JOIN users u ON c.user_id = u.id
ORDER BY u.username, c.created_at;

-- Get contacts grouped by type
SELECT 
    contact_type,
    COUNT(*) as count
FROM contacts
GROUP BY contact_type
ORDER BY count DESC;

-- Get user contact info
SELECT 
    contact_type,
    contact_value
FROM contacts
WHERE user_id = 1
ORDER BY contact_type;

-- ============================================================================
-- ACTIVITY LOGS QUERIES
-- ============================================================================

-- Get recent activity
SELECT 
    al.id,
    u.username,
    al.action,
    al.description,
    al.ip_address,
    al.created_at
FROM activity_logs al
LEFT JOIN users u ON al.user_id = u.id
ORDER BY al.created_at DESC
LIMIT 50;

-- Get activity count by action
SELECT 
    action,
    COUNT(*) as count,
    MAX(created_at) as last_activity
FROM activity_logs
GROUP BY action
ORDER BY count DESC;

-- Get user activity history
SELECT 
    id,
    action,
    description,
    ip_address,
    created_at
FROM activity_logs
WHERE user_id = 1
ORDER BY created_at DESC;

-- ============================================================================
-- DATABASE STATISTICS QUERIES
-- ============================================================================

-- Get database size
SELECT 
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb
FROM information_schema.tables
WHERE table_schema = 'prantik_website';

-- Get table sizes
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) as size_mb,
    table_rows as row_count
FROM information_schema.tables
WHERE table_schema = 'prantik_website'
ORDER BY (data_length + index_length) DESC;

-- Get detailed table information
SELECT 
    TABLE_NAME,
    ENGINE,
    TABLE_COLLATION,
    TABLE_ROWS,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) as size_mb,
    AUTO_INCREMENT
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'prantik_website'
ORDER BY TABLE_ROWS DESC;

-- ============================================================================
-- DATA INTEGRITY CHECKS
-- ============================================================================

-- Check for orphaned user references
SELECT DISTINCT c.user_id
FROM contacts c
WHERE c.user_id NOT IN (SELECT id FROM users);

-- Check for duplicate emails
SELECT 
    email,
    COUNT(*) as count
FROM users
GROUP BY email
HAVING COUNT(*) > 1;

-- Check for null emails in users
SELECT id, username FROM users WHERE email IS NULL;

-- Check for messages without email address
SELECT id, name FROM messages WHERE email IS NULL OR email = '';

-- ============================================================================
-- MAINTENANCE QUERIES
-- ============================================================================

-- Optimize all tables
OPTIMIZE TABLE users, messages, contacts, activity_logs, sessions;

-- Repair all tables (if needed)
-- REPAIR TABLE users, messages, contacts, activity_logs, sessions;

-- Check table status
CHECK TABLE users, messages, contacts, activity_logs, sessions;

-- Analyze all tables
ANALYZE TABLE users, messages, contacts, activity_logs, sessions;

-- ============================================================================
-- DATA CLEANUP QUERIES (USE WITH CAUTION!)
-- ============================================================================

-- Delete user and all related data (cascade delete)
-- DELETE FROM users WHERE id = 1;

-- Delete all unread messages
-- DELETE FROM messages WHERE is_read = FALSE;

-- Delete messages older than specified date
-- DELETE FROM messages WHERE created_at < '2025-01-01';

-- Clear activity logs older than 6 months
-- DELETE FROM activity_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 MONTH);

-- Clear sessions older than 30 days
-- DELETE FROM sessions WHERE expires_at < NOW();

-- ============================================================================
-- EXPORT/IMPORT QUERIES
-- ============================================================================

-- Export users to CSV
SELECT 'ID', 'Username', 'Email', 'Full Name', 'Location', 'Bio', 'Phone', 'Joined', 'Last Login'
UNION ALL
SELECT CAST(id AS CHAR), username, email, IFNULL(full_name, ''), IFNULL(location, ''), IFNULL(bio, ''), IFNULL(phone, ''), created_at, IFNULL(last_login, '')
FROM users
INTO OUTFILE '/tmp/users_export.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';

-- Export messages to CSV
SELECT 'ID', 'Name', 'Email', 'Subject', 'Message', 'Created At', 'Is Read'
UNION ALL
SELECT CAST(id AS CHAR), name, email, subject, message, created_at, is_read
FROM messages
INTO OUTFILE '/tmp/messages_export.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';

-- ============================================================================
-- END OF QUERIES
-- ============================================================================
