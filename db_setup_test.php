<?php
/**
 * Database Setup & Testing Script
 * Run this script to initialize your database and verify connection
 */

session_start();
include 'db_connect.php';

$setup_status = [
    'database_created' => false,
    'tables_created' => false,
    'sample_data_inserted' => false,
    'connection_healthy' => false,
    'errors' => []
];

// Test database connection
$health = checkDatabaseHealth($conn);
$setup_status['connection_healthy'] = $health['connected'];
if (!$health['connected']) {
    $setup_status['errors'] = array_merge($setup_status['errors'], $health['errors']);
}

// Check if database exists
if ($health['connected']) {
    // Verify tables
    $required_tables = ['users', 'messages', 'contacts'];
    $tables_exist = true;
    
    foreach ($required_tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows === 0) {
            $tables_exist = false;
            $setup_status['errors'][] = "Table '$table' not found. Please run db_setup.sql";
        }
    }
    
    if ($tables_exist) {
        $setup_status['tables_created'] = true;
        
        // Check for sample data
        $user_count = getRow($conn, "SELECT COUNT(*) as count FROM users")['count'] ?? 0;
        if ($user_count > 0) {
            $setup_status['sample_data_inserted'] = true;
        }
    }
}

$stats = $setup_status['connection_healthy'] ? getDatabaseStats($conn) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Prantik Website</title>
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
            max-width: 800px;
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
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .content {
            padding: 30px;
        }

        .status-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border-left: 4px solid #ddd;
            background: #f9fafb;
        }

        .status-item.success {
            border-left-color: #22c55e;
            background: #f0fdf4;
        }

        .status-item.error {
            border-left-color: #ef4444;
            background: #fef2f2;
        }

        .status-item.warning {
            border-left-color: #f59e0b;
            background: #fffbeb;
        }

        .status-icon {
            font-size: 20px;
            margin-right: 15px;
            min-width: 20px;
        }

        .status-item.success .status-icon {
            color: #22c55e;
        }

        .status-item.error .status-icon {
            color: #ef4444;
        }

        .status-item.warning .status-icon {
            color: #f59e0b;
        }

        .status-text {
            flex: 1;
        }

        .status-text h3 {
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }

        .status-text p {
            font-size: 14px;
            color: #666;
        }

        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-box h3 {
            color: #1e40af;
            margin-bottom: 8px;
        }

        .info-box p {
            color: #1e3a8a;
            font-size: 14px;
            line-height: 1.6;
        }

        .error-list {
            margin-top: 15px;
            padding-left: 20px;
        }

        .error-list li {
            color: #dc2626;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .stat-card {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card h4 {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
            color: white;
        }

        .step.completed .step-circle {
            background: #22c55e;
        }

        .step.active .step-circle {
            background: #667eea;
        }

        .step label {
            font-size: 14px;
            color: #666;
            display: block;
        }

        @media (max-width: 600px) {
            .actions {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-database"></i>
                Database Setup & Status
            </h1>
            <p>Prantik Website Database Configuration</p>
        </div>

        <div class="content">
            <!-- Setup Progress -->
            <div class="step-indicator">
                <div class="step <?php echo $setup_status['connection_healthy'] ? 'completed' : 'active'; ?>">
                    <div class="step-circle">
                        <?php echo $setup_status['connection_healthy'] ? '✓' : '1'; ?>
                    </div>
                    <label>Connection</label>
                </div>
                <div class="step <?php echo $setup_status['tables_created'] ? 'completed' : ''; ?>">
                    <div class="step-circle">
                        <?php echo $setup_status['tables_created'] ? '✓' : '2'; ?>
                    </div>
                    <label>Tables</label>
                </div>
                <div class="step <?php echo $setup_status['sample_data_inserted'] ? 'completed' : ''; ?>">
                    <div class="step-circle">
                        <?php echo $setup_status['sample_data_inserted'] ? '✓' : '3'; ?>
                    </div>
                    <label>Data</label>
                </div>
            </div>

            <!-- Status Items -->
            <div class="status-item <?php echo $setup_status['connection_healthy'] ? 'success' : 'error'; ?>">
                <div class="status-icon">
                    <?php echo $setup_status['connection_healthy'] ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'; ?>
                </div>
                <div class="status-text">
                    <h3>Database Connection</h3>
                    <p><?php echo $setup_status['connection_healthy'] ? 'Connected to ' . DB_NAME . ' on ' . DB_HOST : 'Connection Failed'; ?></p>
                </div>
            </div>

            <div class="status-item <?php echo $setup_status['tables_created'] ? 'success' : ($setup_status['connection_healthy'] ? 'warning' : 'error'); ?>">
                <div class="status-icon">
                    <?php echo $setup_status['tables_created'] ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>'; ?>
                </div>
                <div class="status-text">
                    <h3>Database Tables</h3>
                    <p><?php echo $setup_status['tables_created'] ? 'All required tables created' : 'Tables not found - Run db_setup.sql'; ?></p>
                </div>
            </div>

            <div class="status-item <?php echo $setup_status['sample_data_inserted'] ? 'success' : 'warning'; ?>">
                <div class="status-icon">
                    <?php echo $setup_status['sample_data_inserted'] ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-info-circle"></i>'; ?>
                </div>
                <div class="status-text">
                    <h3>Sample Data</h3>
                    <p><?php echo $setup_status['sample_data_inserted'] ? 'Sample data initialized' : 'No sample data found'; ?></p>
                </div>
            </div>

            <!-- Statistics -->
            <?php if ($setup_status['connection_healthy']): ?>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>Users</h4>
                        <div class="number"><?php echo $stats['users_count'] ?? 0; ?></div>
                    </div>
                    <div class="stat-card">
                        <h4>Messages</h4>
                        <div class="number"><?php echo $stats['messages_count'] ?? 0; ?></div>
                    </div>
                    <div class="stat-card">
                        <h4>Unread</h4>
                        <div class="number"><?php echo $stats['unread_messages'] ?? 0; ?></div>
                    </div>
                    <div class="stat-card">
                        <h4>DB Size</h4>
                        <div class="number"><?php echo $stats['size_mb'] ?? 0; ?> MB</div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Info Box -->
            <div class="info-box">
                <h3><i class="fas fa-info-circle"></i> Setup Instructions</h3>
                <p>
                    <strong>Step 1:</strong> If tables are not created, import the <code>db_setup.sql</code> file using phpMyAdmin.<br>
                    <strong>Step 2:</strong> Visit the database analysis dashboard for detailed statistics.<br>
                    <strong>Step 3:</strong> Test your application by registering or logging in.
                </p>
            </div>

            <!-- Errors -->
            <?php if (!empty($setup_status['errors'])): ?>
                <div class="status-item error">
                    <div class="status-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="status-text">
                        <h3>Setup Issues Detected</h3>
                        <ul class="error-list">
                            <?php foreach ($setup_status['errors'] as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="actions">
                <a href="db_analyze.php" class="btn btn-primary">
                    <i class="fas fa-chart-bar"></i> View Dashboard
                </a>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Back to Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>
