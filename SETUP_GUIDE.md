# Database Setup & Connection Guide

## Overview
This guide will help you set up your Prantik Website database with complete connection management and analysis tools.

## Files Included

### 1. **db_setup.sql** 
Complete SQL script to create and initialize the database with all necessary tables.

**Tables Created:**
- `users` - User account information and profiles
- `messages` - Contact form submissions
- `contacts` - User social media and contact info
- `activity_logs` - Audit trail of user activities
- `sessions` - Session storage (optional)

### 2. **db_connect.php**
Enhanced database connection module with utilities.

**Features:**
- Secure database connection
- Error logging
- Helper functions for common database operations
- Database health checks
- Statistics retrieval

**Helper Functions:**
```php
getDBConnection()           // Get database connection
getRow($conn, $sql, ...)    // Get single row
getAllRows($conn, $sql, ...)// Get multiple rows
insertData($conn, ...)      // Insert data
updateData($conn, ...)      // Update data
deleteData($conn, ...)      // Delete data
getDatabaseStats($conn)     // Get DB statistics
checkDatabaseHealth($conn)  // Check connection health
```

### 3. **db_analyze.php**
Database analysis dashboard with statistics and management interface.

**Features:**
- Real-time database statistics
- User management overview
- Recent messages view
- Table information
- Database health monitoring

## Setup Instructions

### Step 1: Create Database Using phpMyAdmin

1. **Open phpMyAdmin**
   ```
   http://localhost/phpmyadmin
   ```

2. **Import SQL Script**
   - Click on "Import" tab
   - Choose `db_setup.sql` file
   - Click "Go" to execute

**OR Use Command Line:**
```bash
mysql -u root -p < db_setup.sql
```

### Step 2: Update Config Files

**Option A: Use New db_connect.php** (Recommended)
Replace your existing config.php with db_connect.php in all PHP files:

```php
// Old way:
include 'config.php';

// New way:
include 'db_connect.php';
```

**Option B: Keep Existing Structure**
Update your existing config.php:

```php
<?php
include 'db_connect.php';
$conn = getDBConnection();
?>
```

### Step 3: Verify Setup

1. **Check Database**
   ```
   http://localhost/prantik-website/db_analyze.php
   ```
   Should show:
   - ✓ Database Connected
   - ✓ All tables visible
   - ✓ Statistics displayed

2. **Test Login**
   - Go to: `http://localhost/prantik-website/login.php`
   - Email: `prantikboro369@gmail.com`
   - Password: `password123`

## Database Configuration

### Credentials
```
Host: localhost
Username: root
Password: (empty)
Database: prantik_website
Port: 3306
Charset: utf8mb4
```

### Change Database Credentials

Edit `db_connect.php` lines 5-11:
```php
define('DB_HOST', 'localhost');  // Change host
define('DB_USER', 'root');       // Change username
define('DB_PASS', '');           // Add password if needed
define('DB_NAME', 'prantik_website');
define('DB_PORT', 3306);         // Change port if needed
```

### Create Dedicated Database User (Optional)

**Via phpMyAdmin:**
1. Go to "User Accounts"
2. Click "Add user account"
3. Username: `prantik_user`
4. Host: `localhost`
5. Password: `your_secure_password`
6. Privileges: Select `prantik_website` database, grant all privileges

**Via MySQL Command Line:**
```sql
CREATE USER 'prantik_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON prantik_website.* TO 'prantik_user'@'localhost';
FLUSH PRIVILEGES;
```

Then update `db_connect.php`:
```php
define('DB_USER', 'prantik_user');
define('DB_PASS', 'secure_password');
```

## Database Schema

### Users Table
```sql
id              - AUTO_INCREMENT PRIMARY KEY
username        - UNIQUE VARCHAR(50)
email           - UNIQUE VARCHAR(100)
password        - VARCHAR(255) - hashed
full_name       - VARCHAR(100)
location        - VARCHAR(100)
bio             - TEXT
phone           - VARCHAR(20)
profile_picture - VARCHAR(255)
created_at      - TIMESTAMP (DEFAULT CURRENT_TIMESTAMP)
updated_at      - TIMESTAMP (AUTO UPDATE)
last_login      - TIMESTAMP
is_active       - BOOLEAN (DEFAULT TRUE)
```

### Messages Table
```sql
id              - AUTO_INCREMENT PRIMARY KEY
name            - VARCHAR(100)
email           - VARCHAR(100)
subject         - VARCHAR(255)
message         - TEXT
created_at      - TIMESTAMP (DEFAULT CURRENT_TIMESTAMP)
is_read         - BOOLEAN (DEFAULT FALSE)
responded_at    - TIMESTAMP
response        - TEXT
sender_ip       - VARCHAR(45)
```

### Contacts Table
```sql
id              - AUTO_INCREMENT PRIMARY KEY
user_id         - INT (FOREIGN KEY → users.id)
contact_name    - VARCHAR(100)
contact_type    - VARCHAR(50) - e.g., "twitter", "github", "linkedin"
contact_value   - VARCHAR(200)
created_at      - TIMESTAMP
updated_at      - TIMESTAMP
```

### Activity Logs Table
```sql
id              - AUTO_INCREMENT PRIMARY KEY
user_id         - INT (FOREIGN KEY → users.id)
action          - VARCHAR(100) - e.g., "login", "register", "update_profile"
description     - TEXT
ip_address      - VARCHAR(45)
user_agent      - TEXT
created_at      - TIMESTAMP
```

## Using Helper Functions

### Example 1: Get Single User
```php
include 'db_connect.php';

$user = getRow($conn, 
    "SELECT * FROM users WHERE id = ?",
    "i",
    [1]
);

echo $user['username'];
```

### Example 2: Get All Messages
```php
$messages = getAllRows($conn,
    "SELECT * FROM messages WHERE is_read = FALSE",
    "i",
    []
);

foreach ($messages as $msg) {
    echo $msg['subject'];
}
```

### Example 3: Insert New User
```php
$userId = insertData($conn,
    "INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)",
    "ssss",
    [$username, $email, $hashed_password, $full_name]
);

echo "New user created with ID: " . $userId;
```

### Example 4: Update User Profile
```php
$affected = updateData($conn,
    "UPDATE users SET full_name = ?, location = ? WHERE id = ?",
    "ssi",
    [$full_name, $location, $user_id]
);

echo "Updated " . $affected . " record(s)";
```

## Monitoring & Analysis

### Access Dashboard
```
http://localhost/prantik-website/db_analyze.php
```

**Dashboard Features:**
- Total users count
- Total messages count
- Unread messages count
- Database size
- User list with registration dates
- Recent messages
- Table information and sizes

### View Error Logs
Error logs are saved in: `logs/db_errors.log`

```php
// View recent errors
tail -n 50 logs/db_errors.log
```

## Backup & Maintenance

### Backup Database

**Via phpMyAdmin:**
1. Select database `prantik_website`
2. Click "Export"
3. Select format: SQL
4. Click "Go"

**Via Command Line:**
```bash
mysqldump -u root -p prantik_website > prantik_website_backup.sql
```

### Restore from Backup
```bash
mysql -u root -p prantik_website < prantik_website_backup.sql
```

### Optimize Database
```sql
OPTIMIZE TABLE users, messages, contacts, activity_logs, sessions;
```

## Troubleshooting

### Connection Failed
1. Check MySQL server is running
2. Verify credentials in `db_connect.php`
3. Check `logs/db_errors.log` for details

### Table Missing
1. Re-run `db_setup.sql`
2. Check phpMyAdmin to verify database exists

### Permission Denied
1. Verify database user has proper privileges
2. Grant all privileges on `prantik_website` database

### Charset Issues
If you see strange characters, verify UTF-8 charset:
```sql
ALTER DATABASE prantik_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE messages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE contacts CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Security Notes

1. **Passwords:** Always use `password_hash()` for storing passwords
2. **Prepared Statements:** Use prepared statements to prevent SQL injection
3. **Input Validation:** Always validate and sanitize user input
4. **HTTPS:** Use HTTPS in production
5. **Environment Variables:** Store sensitive config in environment variables

## Next Steps

1. ✅ Run `db_setup.sql` to create tables
2. ✅ Update all PHP files to include `db_connect.php`
3. ✅ Test database connection via `db_analyze.php`
4. ✅ Test login with demo account
5. ✅ Monitor database using the dashboard

## Support

For issues or questions, check:
- phpMyAdmin interface
- `logs/db_errors.log` file
- Database health check on `db_analyze.php`

---
**Last Updated:** April 2026
