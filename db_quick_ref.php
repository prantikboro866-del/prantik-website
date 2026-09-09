<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Quick Reference - Prantik Website</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            background: #1e1e1e;
            color: #e0e0e0;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }
        .card {
            background: #2d2d2d;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .card h2 {
            color: #667eea;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .card h3 {
            color: #a8d5ff;
            font-size: 14px;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        code, pre {
            background: #1a1a1a;
            padding: 8px;
            border-radius: 4px;
            display: block;
            overflow-x: auto;
            border-left: 3px solid #667eea;
            margin: 8px 0;
            font-size: 12px;
        }
        .links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        a {
            color: #667eea;
            text-decoration: none;
            padding: 10px;
            background: #3a3a3a;
            border-radius: 4px;
            text-align: center;
            transition: background 0.3s;
        }
        a:hover {
            background: #667eea;
            color: white;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            color: white;
            grid-column: 1 / -1;
        }
        .header h1 { margin-bottom: 10px; }
        .header p { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Database Quick Reference</h1>
        <p>Prantik Website - Database Connection & Usage Guide</p>
    </div>

    <div class="container">
        <!-- Connection Card -->
        <div class="card">
            <h2>🔌 Connection</h2>
            <h3>Configuration</h3>
            <pre>Host: localhost
Database: prantik_website
User: root
Password: (empty)
Port: 3306
Charset: utf8mb4</pre>
            <h3>Get Connection</h3>
            <pre>include 'db_connect.php';
$conn = getDBConnection();</pre>
        </div>

        <!-- Query Examples Card -->
        <div class="card">
            <h2>💾 Data Operations</h2>
            <h3>Get Single Row</h3>
            <pre>$user = getRow($conn,
    "SELECT * FROM users WHERE id = ?",
    "i", [1]);</pre>
            <h3>Get All Rows</h3>
            <pre>$users = getAllRows($conn,
    "SELECT * FROM users");</pre>
            <h3>Insert Data</h3>
            <pre>$id = insertData($conn,
    "INSERT INTO users (...) VALUES (...)",
    "sss", [$val1, $val2, $val3]);</pre>
            <h3>Update Data</h3>
            <pre>$rows = updateData($conn,
    "UPDATE users SET name = ? WHERE id = ?",
    "si", [$name, $id]);</pre>
            <h3>Delete Data</h3>
            <pre>$rows = deleteData($conn,
    "DELETE FROM users WHERE id = ?",
    "i", [$id]);</pre>
        </div>

        <!-- Tables Card -->
        <div class="card">
            <h2>📊 Database Tables</h2>
            <h3>users</h3>
            <pre>id, username, email, password,
full_name, location, bio, phone,
created_at, updated_at, last_login,
is_active</pre>
            <h3>messages</h3>
            <pre>id, name, email, subject, message,
created_at, is_read, responded_at,
response, sender_ip</pre>
            <h3>contacts</h3>
            <pre>id, user_id, contact_name,
contact_type, contact_value,
created_at, updated_at</pre>
            <h3>activity_logs</h3>
            <pre>id, user_id, action, description,
ip_address, user_agent, created_at</pre>
        </div>

        <!-- Helper Functions Card -->
        <div class="card">
            <h2>🛠️ Helper Functions</h2>
            <h3>Statistics</h3>
            <pre>$stats = getDatabaseStats($conn);
// Returns: users_count, messages_count,
// unread_messages, size_mb, table_count</pre>
            <h3>Health Check</h3>
            <pre>$health = checkDatabaseHealth($conn);
// Returns: connected, errors[]</pre>
            <h3>Error Logging</h3>
            <pre>logDatabaseError("Error message");
// Logs to: logs/db_errors.log</pre>
        </div>

        <!-- Common Queries Card -->
        <div class="card">
            <h2>🔍 Common Queries</h2>
            <h3>Count Users</h3>
            <pre>SELECT COUNT(*) FROM users;</pre>
            <h3>Unread Messages</h3>
            <pre>SELECT * FROM messages
WHERE is_read = FALSE;</pre>
            <h3>User with Most Messages</h3>
            <pre>SELECT email, COUNT(*) as count
FROM messages GROUP BY email
ORDER BY count DESC LIMIT 1;</pre>
            <h3>New Users This Week</h3>
            <pre>SELECT * FROM users
WHERE created_at >= 
  DATE_SUB(NOW(), INTERVAL 7 DAY);</pre>
            <h3>Database Size</h3>
            <pre>SELECT ROUND(SUM(data_length + 
  index_length) / 1024 / 1024, 2) as size_mb
FROM information_schema.tables
WHERE table_schema = 'prantik_website';</pre>
        </div>

        <!-- Type Codes Card -->
        <div class="card">
            <h2>📝 Type Codes</h2>
            <h3>Parameter Types</h3>
            <pre>i = integer
s = string
d = double
b = blob</pre>
            <h3>Examples</h3>
            <pre>// String
getRow($conn, "...", "s", [$username]);

// Integer
getRow($conn, "...", "i", [123]);

// Multiple: string, int, string
getRow($conn, "...", "sis",
    [$name, $id, $email]);</pre>
        </div>

        <!-- Important Links Card -->
        <div class="card">
            <h2>🌐 Important Links</h2>
            <h3>Access Your Dashboard</h3>
            <div class="links">
                <a href="/prantik-website/db_setup_test.php">Setup Test</a>
                <a href="/prantik-website/db_analyze.php">Dashboard</a>
                <a href="/prantik-website/">Main Site</a>
                <a href="http://localhost/phpmyadmin/">phpMyAdmin</a>
            </div>
            <h3>Documentation Files</h3>
            <div class="links">
                <a href="/prantik-website/DB_README.md">README</a>
                <a href="/prantik-website/SETUP_GUIDE.md">Setup Guide</a>
                <a href="/prantik-website/DB_QUERIES.sql">SQL Queries</a>
                <a href="/prantik-website/db_connect.php">Source Code</a>
            </div>
        </div>

        <!-- Troubleshooting Card -->
        <div class="card">
            <h2>🔧 Troubleshooting</h2>
            <h3>Connection Failed</h3>
            <pre>1. Check MySQL running
2. Verify host/port/user in
   db_connect.php
3. Check logs/db_errors.log</pre>
            <h3>Tables Not Found</h3>
            <pre>1. Import db_setup.sql
2. Or run in MySQL:
   mysql -u root < db_setup.sql
3. Verify in phpMyAdmin</pre>
            <h3>Can't Login</h3>
            <pre>Email: prantikboro369@gmail.com
Password: password123

If not exists, re-run db_setup.sql
to add sample user</pre>
        </div>

        <!-- Demo User Card -->
        <div class="card">
            <h2>👤 Demo Account</h2>
            <h3>Login Credentials</h3>
            <pre>Email: prantikboro369@gmail.com
Password: password123</pre>
            <h3>Test Data</h3>
            <pre>Username: prantik
Full Name: Prantik Boro
Location: Guwahati, Assam
Phone: 8474831319</pre>
        </div>

        <!-- File Structure Card -->
        <div class="card">
            <h2>📁 Database Files</h2>
            <h3>SQL & Config</h3>
            <pre>db_setup.sql
db_connect.php
DB_QUERIES.sql</pre>
            <h3>Web Interface</h3>
            <pre>db_setup_test.php
db_analyze.php
db_quick_ref.php</pre>
            <h3>Documentation</h3>
            <pre>DB_README.md
SETUP_GUIDE.md</pre>
        </div>

        <!-- Setup Steps Card -->
        <div class="card">
            <h2>✅ Setup Checklist</h2>
            <h3>Step 1: Create Database</h3>
            <pre>phpMyAdmin → Import → db_setup.sql
OR
mysql -u root < db_setup.sql</pre>
            <h3>Step 2: Verify</h3>
            <pre>Visit: http://localhost/
prantik-website/db_setup_test.php</pre>
            <h3>Step 3: Test</h3>
            <pre>Visit: http://localhost/
prantik-website/db_analyze.php</pre>
            <h3>Step 4: Use</h3>
            <pre>include 'db_connect.php';
$conn = getDBConnection();
// Use helper functions</pre>
        </div>

        <!-- Performance Tips Card -->
        <div class="card">
            <h2>⚡ Performance Tips</h2>
            <h3>Indexing</h3>
            <pre>Tables have indexes on:
- email (unique)
- username (unique)
- user_id (foreign key)
- created_at (for sorting)
- contact_type (for filtering)</pre>
            <h3>Best Practices</h3>
            <pre>1. Always use prepared statements
2. Limit result sets with LIMIT
3. Use appropriate SELECT columns
4. Index frequently searched fields
5. Monitor logs/db_errors.log</pre>
        </div>
    </div>
</body>
</html>
