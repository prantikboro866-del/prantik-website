<?php
/**
 * Database Analysis Dashboard
 * Displays comprehensive database statistics and analysis
 */

session_start();

// Check if user is admin (optional - remove this if authentication not needed for analysis)
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

include 'db_connect.php';

$current_page = 'db_analyze';
$analysis_data = [];

// Get database statistics
try {
    // Overall stats
    $stats = getDatabaseStats($conn);
    
    // Users analysis
    $users_stats = getRow($conn, 
        "SELECT COUNT(*) as total, 
                SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_this_week
         FROM users"
    );

    // Messages analysis
    $messages_stats = getRow($conn,
        "SELECT COUNT(*) as total,
                SUM(CASE WHEN is_read = FALSE THEN 1 ELSE 0 END) as unread,
                SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_this_week
         FROM messages"
    );

    // Get all users
    $all_users = getAllRows($conn,
        "SELECT id, username, email, full_name, created_at, last_login, is_active 
         FROM users 
         ORDER BY created_at DESC"
    );

    // Get recent messages
    $recent_messages = getAllRows($conn,
        "SELECT id, name, email, subject, created_at, is_read 
         FROM messages 
         ORDER BY created_at DESC 
         LIMIT 10"
    );

    // Get table information
    $table_info = getAllRows($conn,
        "SELECT 
            TABLE_NAME,
            TABLE_ROWS,
            ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb,
            ENGINE,
            TABLE_COLLATION
         FROM information_schema.TABLES 
         WHERE TABLE_SCHEMA = ?
         ORDER BY TABLE_ROWS DESC",
        's',
        [DB_NAME]
    );

    // Database health check
    $health = checkDatabaseHealth($conn);

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Analysis - Prantik Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .health-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-size: 14px;
        }

        .health-status.connected::before {
            content: "●";
            color: #4ade80;
            font-size: 16px;
        }

        .health-status.disconnected::before {
            content: "●";
            color: #ef4444;
            font-size: 16px;
        }

        .content {
            padding: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
        }

        .stat-card.secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card.success {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
        }

        .stat-card.warning {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .section {
            margin-bottom: 40px;
        }

        .section h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        table thead {
            background: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }

        table tbody tr:hover {
            background: #f9fafb;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge.inactive {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .badge.read {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge.unread {
            background: #fed7aa;
            color: #92400e;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
            font-size: 16px;
        }

        .refresh-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .refresh-btn:hover {
            background: #764ba2;
        }

        .footer {
            background: #f3f4f6;
            padding: 20px 30px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 14px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            table th, table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>
                    <i class="fas fa-database"></i>
                    Database Analysis
                </h1>
            </div>
            <div>
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Website
                </a>
            </div>
        </div>

        <div class="content">
            <!-- Health Status -->
            <div style="margin-bottom: 30px;">
                <div class="health-status <?php echo $health['connected'] ? 'connected' : 'disconnected'; ?>">
                    <?php echo $health['connected'] ? 'Database Connected' : 'Database Disconnected'; ?>
                </div>
                <?php if (!empty($health['errors'])): ?>
                    <div style="margin-top: 10px; padding: 10px; background: #fee2e2; color: #dc2626; border-radius: 5px;">
                        <strong>Errors:</strong>
                        <ul>
                            <?php foreach ($health['errors'] as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><i class="fas fa-users"></i> Total Users</h3>
                    <div class="number"><?php echo $users_stats['total'] ?? 0; ?></div>
                </div>
                <div class="stat-card secondary">
                    <h3><i class="fas fa-envelope"></i> Total Messages</h3>
                    <div class="number"><?php echo $messages_stats['total'] ?? 0; ?></div>
                </div>
                <div class="stat-card warning">
                    <h3><i class="fas fa-bell"></i> Unread Messages</h3>
                    <div class="number"><?php echo $messages_stats['unread'] ?? 0; ?></div>
                </div>
                <div class="stat-card success">
                    <h3><i class="fas fa-database"></i> Database Size</h3>
                    <div class="number"><?php echo $stats['size_mb']; ?> MB</div>
                </div>
            </div>

            <!-- Users Section -->
            <div class="section">
                <h2>
                    <i class="fas fa-users"></i>
                    Users Management
                </h2>
                <?php if (count($all_users) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Joined</th>
                                <th>Last Login</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['full_name'] ?? '-'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                    <td><?php echo $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                                    <td>
                                        <span class="badge <?php echo $user['is_active'] ? 'active' : 'inactive'; ?>">
                                            <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No users found</div>
                <?php endif; ?>
            </div>

            <!-- Recent Messages Section -->
            <div class="section">
                <h2>
                    <i class="fas fa-envelope"></i>
                    Recent Messages
                </h2>
                <?php if (count($recent_messages) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Received</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_messages as $msg): ?>
                                <tr>
                                    <td><?php echo $msg['id']; ?></td>
                                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></td>
                                    <td>
                                        <span class="badge <?php echo $msg['is_read'] ? 'read' : 'unread'; ?>">
                                            <?php echo $msg['is_read'] ? 'Read' : 'Unread'; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No messages found</div>
                <?php endif; ?>
            </div>

            <!-- Database Tables Information -->
            <div class="section">
                <h2>
                    <i class="fas fa-table"></i>
                    Database Tables
                </h2>
                <?php if (count($table_info) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Table Name</th>
                                <th>Rows</th>
                                <th>Size (MB)</th>
                                <th>Engine</th>
                                <th>Collation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table_info as $table): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($table['TABLE_NAME']); ?></strong></td>
                                    <td><?php echo number_format($table['TABLE_ROWS']); ?></td>
                                    <td><?php echo $table['size_mb']; ?></td>
                                    <td><?php echo htmlspecialchars($table['ENGINE']); ?></td>
                                    <td><?php echo htmlspecialchars($table['TABLE_COLLATION']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No tables found</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer">
            <p>Database Analysis Dashboard | Last Updated: <?php echo date('M d, Y H:i:s'); ?></p>
        </div>
    </div>
</body>
</html>
