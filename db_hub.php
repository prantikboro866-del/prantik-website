<?php
/**
 * Database Setup & Documentation Hub
 * Central location for all database-related resources
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Hub - Prantik Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .navbar a:hover {
            background: rgba(255,255,255,0.2);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .hero {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 40px;
        }

        .hero h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .hero p {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .action-btn.secondary {
            background: #e5e7eb;
            color: #333;
        }

        .action-btn.secondary:hover {
            background: #d1d5db;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            color: #333;
            font-size: 22px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            border-top: 4px solid #667eea;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-icon {
            font-size: 32px;
            color: #667eea;
            margin-bottom: 15px;
        }

        .card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .card a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s;
        }

        .card a:hover {
            gap: 12px;
        }

        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box h4 {
            color: #1e40af;
            margin-bottom: 8px;
        }

        .info-box p {
            color: #1e3a8a;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }

        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-top: 4px solid #667eea;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        .footer {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            color: #666;
            margin-top: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .code-block {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin: 10px 0;
            border-left: 3px solid #667eea;
        }

        @media (max-width: 768px) {
            .hero h2 {
                font-size: 22px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="navbar">
        <div class="navbar-content">
            <h1><i class="fas fa-database"></i> Database Hub</h1>
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
        </div>
    </div>

    <div class="container">
        <!-- Hero Section -->
        <div class="hero">
            <h2>🎉 Database Setup Complete!</h2>
            <p>Your Prantik Website now has a fully configured database system with dashboard, analytics, and documentation.</p>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="db_setup_test.php" class="action-btn">
                <i class="fas fa-check-circle"></i> Verify Setup
            </a>
            <a href="db_analyze.php" class="action-btn">
                <i class="fas fa-chart-bar"></i> Dashboard
            </a>
            <a href="db_visual_guide.php" class="action-btn">
                <i class="fas fa-graduation-cap"></i> Setup Guide
            </a>
            <a href="db_quick_ref.php" class="action-btn">
                <i class="fas fa-book"></i> Quick Ref
            </a>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <h4><i class="fas fa-lightbulb"></i> Getting Started</h4>
            <p>
                <strong>Step 1:</strong> If database not created, import db_setup.sql via phpMyAdmin.<br>
                <strong>Step 2:</strong> Click "Verify Setup" to check everything is working.<br>
                <strong>Step 3:</strong> Access the Dashboard to view your data!
            </p>
        </div>

        <!-- Statistics -->
        <div class="section">
            <h2 class="section-title">📊 Database Overview</h2>
            <div class="stats">
                <div class="stat-box">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Tables Created</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Helper Functions</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">40+</div>
                    <div class="stat-label">SQL Queries</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">6</div>
                    <div class="stat-label">Documentation Files</div>
                </div>
            </div>
        </div>

        <!-- Tools & Resources -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-tools"></i> Tools & Resources</h2>
            <div class="grid">
                <div class="card">
                    <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                    <h3>Setup Verification</h3>
                    <p>Test your database connection and verify all tables are created correctly.</p>
                    <a href="db_setup_test.php">Test Now <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-chart-bar"></i></div>
                    <h3>Analysis Dashboard</h3>
                    <p>Real-time dashboard with statistics, user management, and health monitoring.</p>
                    <a href="db_analyze.php">View Dashboard <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-graduation-cap"></i></div>
                    <h3>Visual Setup Guide</h3>
                    <p>Step-by-step visual guide with interactive elements and troubleshooting.</p>
                    <a href="db_visual_guide.php">Start Learning <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-book"></i></div>
                    <h3>Quick Reference</h3>
                    <p>Quick reference with code examples, queries, and common operations.</p>
                    <a href="db_quick_ref.php">View Reference <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-database"></i></div>
                    <h3>SQL Setup Script</h3>
                    <p>Complete SQL script to create database, tables, and sample data.</p>
                    <a href="db_setup.sql">View Script <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-list"></i></div>
                    <h3>SQL Query Collection</h3>
                    <p>40+ ready-to-use SQL queries for analysis and management.</p>
                    <a href="DB_QUERIES.sql">View Queries <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Documentation -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-file-alt"></i> Documentation</h2>
            <div class="grid">
                <div class="card">
                    <div class="card-icon"><i class="fas fa-file"></i></div>
                    <h3>DB_README.md</h3>
                    <p>Quick start guide with 3-step setup process and overview.</p>
                    <a href="DB_README.md">Read <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-file"></i></div>
                    <h3>SETUP_GUIDE.md</h3>
                    <p>Comprehensive setup guide with detailed instructions and troubleshooting.</p>
                    <a href="SETUP_GUIDE.md">Read <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-file"></i></div>
                    <h3>INSTALLATION_SUMMARY.md</h3>
                    <p>Complete summary of what was created and how to use everything.</p>
                    <a href="INSTALLATION_SUMMARY.md">Read <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="fas fa-file"></i></div>
                    <h3>db_connect.php</h3>
                    <p>Enhanced connection module with helper functions and documentation.</p>
                    <a href="db_connect.php">View <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Database Tables -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-table"></i> Database Tables</h2>
            <div class="grid">
                <div class="card">
                    <h3>👥 users</h3>
                    <p>User account information and profiles</p>
                    <div class="code-block">
id, username, email, password<br>
full_name, location, bio, phone<br>
created_at, updated_at, last_login
                    </div>
                </div>

                <div class="card">
                    <h3>💬 messages</h3>
                    <p>Contact form submissions and tracking</p>
                    <div class="code-block">
id, name, email, subject, message<br>
is_read, responded_at, response<br>
created_at, sender_ip
                    </div>
                </div>

                <div class="card">
                    <h3>📞 contacts</h3>
                    <p>Social media and contact information</p>
                    <div class="code-block">
id, user_id (FK)<br>
contact_name, contact_type<br>
contact_value, timestamps
                    </div>
                </div>

                <div class="card">
                    <h3>📋 activity_logs</h3>
                    <p>Audit trail and user activity tracking</p>
                    <div class="code-block">
id, user_id (FK)<br>
action, description<br>
ip_address, user_agent, created_at
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuration -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-cog"></i> Configuration</h2>
            <div class="info-box">
                <h4>Database Credentials</h4>
                <p style="margin-bottom: 10px;">
                    <strong>Host:</strong> localhost | 
                    <strong>User:</strong> root | 
                    <strong>Password:</strong> (empty) | 
                    <strong>Database:</strong> prantik_website
                </p>
                <p>To change credentials, edit db_connect.php lines 3-6</p>
            </div>

            <div class="info-box" style="background: #f0fdf4; border-left-color: #22c55e;">
                <h4><i class="fas fa-user"></i> Demo Account</h4>
                <p>
                    <strong>Email:</strong> prantikboro369@gmail.com<br>
                    <strong>Password:</strong> password123<br>
                    Use this to test login functionality
                </p>
            </div>
        </div>

        <!-- Helper Functions -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-code"></i> Helper Functions</h2>
            <div class="info-box">
                <h4>Use These Functions in Your PHP Code</h4>
                <div class="code-block">
// Connection
$conn = getDBConnection();

// Read Data
$row = getRow($conn, "SELECT * FROM users WHERE id = ?", "i", [1]);
$rows = getAllRows($conn, "SELECT * FROM users");

// Write Data
$id = insertData($conn, "INSERT INTO ...", "sss", [$v1, $v2, $v3]);
$affected = updateData($conn, "UPDATE ...", "si", [$name, $id]);
$deleted = deleteData($conn, "DELETE FROM ...", "i", [$id]);

// Monitor
$stats = getDatabaseStats($conn);
$health = checkDatabaseHealth($conn);
                </div>
                <p style="margin-top: 15px;">See db_connect.php for full documentation of all functions</p>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-rocket"></i> Next Steps</h2>
            <div class="info-box">
                <ol style="margin-left: 20px; color: #1e3a8a;">
                    <li style="margin-bottom: 10px;">
                        <strong>Import Database:</strong> Run db_setup.sql via phpMyAdmin or command line
                    </li>
                    <li style="margin-bottom: 10px;">
                        <strong>Verify Setup:</strong> Click "Verify Setup" button above to test connection
                    </li>
                    <li style="margin-bottom: 10px;">
                        <strong>Access Dashboard:</strong> Click "Dashboard" to view real-time statistics
                    </li>
                    <li style="margin-bottom: 10px;">
                        <strong>Read Documentation:</strong> Review SETUP_GUIDE.md for detailed instructions
                    </li>
                    <li style="margin-bottom: 10px;">
                        <strong>Test Login:</strong> Use demo credentials to verify authentication
                    </li>
                    <li>
                        <strong>Start Building:</strong> Use helper functions to build your features!
                    </li>
                </ol>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Database Setup Complete! ✨</strong></p>
            <p style="margin-top: 10px;">
                Your Prantik Website now has a powerful, secure, and well-documented database system.<br>
                For questions or issues, refer to the documentation files or check the logs/db_errors.log file.
            </p>
            <p style="margin-top: 15px; font-size: 12px; opacity: 0.7;">
                Prantik Website v2.0 | Database Setup April 2026
            </p>
        </div>
    </div>
</body>
</html>
