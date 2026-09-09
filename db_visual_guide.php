<!-- Database Setup Quick Start Guide (Visual) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Visual Guide</title>
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
        }

        .header {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .header h1 {
            color: #667eea;
            font-size: 36px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 16px;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .step {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .step::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 50%;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .step h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .step p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .step-content {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid #667eea;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin: 15px 0;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
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
            background: linear-gradient(135deg, #667eea, #764ba2);
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

        .files {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .files h2 {
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .file-item {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s;
        }

        .file-item:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .file-icon {
            font-size: 24px;
            color: #667eea;
            min-width: 24px;
        }

        .file-info h3 {
            color: #333;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .file-info p {
            color: #999;
            font-size: 12px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
        }

        .feature-icon {
            font-size: 36px;
            color: #667eea;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .troubleshooting {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .troubleshooting h2 {
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .issue {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .issue:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .issue h3 {
            color: #ef4444;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .issue p {
            color: #666;
            margin-bottom: 8px;
        }

        .solution {
            background: #f0fdf4;
            padding: 12px;
            border-left: 3px solid #22c55e;
            border-radius: 5px;
            color: #166534;
            font-size: 14px;
        }

        .success-box {
            background: #f0fdf4;
            border: 2px solid #22c55e;
            padding: 20px;
            border-radius: 8px;
            color: #166534;
            margin: 20px 0;
        }

        .success-box strong {
            display: block;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 24px;
            }

            .steps, .features {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-database"></i> Database Setup Guide</h1>
            <p>Complete setup for Prantik Website Database</p>
        </div>

        <!-- Quick Start Steps -->
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h2>Import Database</h2>
                <p>Create and initialize your database with the SQL schema</p>
                <div class="step-content">
                    <strong>Option A (phpMyAdmin)</strong><br>
                    1. http://localhost/phpmyadmin<br>
                    2. Import tab<br>
                    3. Select db_setup.sql<br>
                    4. Click Go
                </div>
                <div class="step-content">
                    <strong>Option B (Command Line)</strong><br>
                    mysql -u root &lt; db_setup.sql
                </div>
                <div class="btn-group">
                    <a href="http://localhost/phpmyadmin" class="btn btn-primary">
                        <i class="fas fa-external-link-alt"></i> phpMyAdmin
                    </a>
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <h2>Verify Setup</h2>
                <p>Check if the database was created successfully</p>
                <div class="step-content">
                    ✓ Connection status<br>
                    ✓ Tables created<br>
                    ✓ Sample data<br>
                    ✓ Statistics
                </div>
                <div class="success-box">
                    <strong>Look for green checkmarks!</strong>
                    All items should show as complete.
                </div>
                <div class="btn-group">
                    <a href="db_setup_test.php" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Run Test
                    </a>
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <h2>Access Dashboard</h2>
                <p>View and analyze your database with the dashboard</p>
                <div class="step-content">
                    Real-time statistics<br>
                    User management<br>
                    Message monitoring<br>
                    Health checks
                </div>
                <div class="success-box">
                    <strong>Full database visibility!</strong>
                    Track users, messages, and system health.
                </div>
                <div class="btn-group">
                    <a href="db_analyze.php" class="btn btn-primary">
                        <i class="fas fa-chart-bar"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Features -->
        <h2 style="color: white; margin-bottom: 20px; text-align: center;">
            <i class="fas fa-star"></i> Features Included
        </h2>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <h3>Secure Connection</h3>
                <p>Built-in security with prepared statements and error handling</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>User Management</h3>
                <p>Complete user account system with profiles and tracking</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-envelope"></i></div>
                <h3>Message System</h3>
                <p>Contact form with read/unread tracking and responses</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Analytics</h3>
                <p>Real-time statistics and comprehensive dashboard</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-code"></i></div>
                <h3>Helper Functions</h3>
                <p>8 ready-to-use functions for common database operations</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-book"></i></div>
                <h3>Documentation</h3>
                <p>Complete guides and code examples for everything</p>
            </div>
        </div>

        <!-- Files Created -->
        <div class="files">
            <h2><i class="fas fa-folder"></i> Files Created</h2>
            <div class="file-grid">
                <div class="file-item">
                    <div class="file-icon"><i class="fas fa-database"></i></div>
                    <div class="file-info">
                        <h3>db_setup.sql</h3>
                        <p>Database schema & tables</p>
                    </div>
                </div>
                <div class="file-item">
                    <div class="file-icon"><i class="fas fa-code"></i></div>
                    <div class="file-info">
                        <h3>db_connect.php</h3>
                        <p>Connection & helpers</p>
                    </div>
                </div>
                <div class="file-item">
                    <div class="file-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="file-info">
                        <h3>db_analyze.php</h3>
                        <p>Analysis dashboard</p>
                    </div>
                </div>
                <div class="file-item">
                    <div class="file-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="file-info">
                        <h3>db_setup_test.php</h3>
                        <p>Setup verification</p>
                    </div>
                </div>
                <div class="file-item">
                    <div class="file-icon"><i class="fas fa-book"></i></div>
                    <div class="file-info">
                        <h3>SETUP_GUIDE.md</h3>
                        <p>Detailed guide</p>
                    </div>
                </div>
                <div class="file-item">
                    <div class="file-icon"><i class="fas fa-list"></i></div>
                    <div class="file-info">
                        <h3>DB_QUERIES.sql</h3>
                        <p>Query examples</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Troubleshooting -->
        <div class="troubleshooting">
            <h2><i class="fas fa-wrench"></i> Troubleshooting</h2>
            
            <div class="issue">
                <h3><i class="fas fa-times-circle"></i> Connection Failed</h3>
                <p>Error: "Connection failed" when accessing dashboard</p>
                <div class="solution">
                    ✓ Ensure MySQL is running in XAMPP Control Panel<br>
                    ✓ Check credentials in db_connect.php<br>
                    ✓ Verify database name is 'prantik_website'
                </div>
            </div>

            <div class="issue">
                <h3><i class="fas fa-times-circle"></i> Tables Not Found</h3>
                <p>Error: "Table 'users' doesn't exist"</p>
                <div class="solution">
                    ✓ Import db_setup.sql via phpMyAdmin<br>
                    ✓ Or run: mysql -u root &lt; db_setup.sql<br>
                    ✓ Refresh the page and try again
                </div>
            </div>

            <div class="issue">
                <h3><i class="fas fa-times-circle"></i> Can't Login</h3>
                <p>Demo account not working</p>
                <div class="solution">
                    ✓ Email: prantikboro369@gmail.com<br>
                    ✓ Password: password123<br>
                    ✓ If not exists, re-run db_setup.sql
                </div>
            </div>

            <div class="issue">
                <h3><i class="fas fa-times-circle"></i> Strange Characters</h3>
                <p>UTF-8 encoding issues</p>
                <div class="solution">
                    ✓ Check DB_CHARSET = 'utf8mb4' in db_connect.php<br>
                    ✓ Verify database collation in phpMyAdmin<br>
                    ✓ Update table collation if needed
                </div>
            </div>
        </div>

        <!-- Database Credentials -->
        <div style="background: white; padding: 30px; border-radius: 15px; margin-top: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <h2 style="color: #333; margin-bottom: 20px;">
                <i class="fas fa-key"></i> Database Configuration
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #667eea;">Host</strong><br>
                    <code>localhost</code>
                </div>
                <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #667eea;">Database</strong><br>
                    <code>prantik_website</code>
                </div>
                <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #667eea;">User</strong><br>
                    <code>root</code>
                </div>
                <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #667eea;">Password</strong><br>
                    <code>(empty)</code>
                </div>
                <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #667eea;">Port</strong><br>
                    <code>3306</code>
                </div>
                <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #667eea;">Charset</strong><br>
                    <code>utf8mb4</code>
                </div>
            </div>
        </div>

        <!-- Demo Account -->
        <div style="background: white; padding: 30px; border-radius: 15px; margin-top: 30px; margin-bottom: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <h2 style="color: #333; margin-bottom: 20px;">
                <i class="fas fa-user-circle"></i> Demo Account
            </h2>
            <div style="padding: 20px; background: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 8px;">
                <p style="margin-bottom: 10px;"><strong>Email:</strong> prantikboro369@gmail.com</p>
                <p style="margin-bottom: 10px;"><strong>Password:</strong> password123</p>
                <p style="color: #666;"><em>Use these credentials to test login functionality</em></p>
            </div>
        </div>

        <!-- Navigation Links -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 40px;">
            <a href="index.php" class="btn btn-primary" style="padding: 15px; text-align: center;">
                <i class="fas fa-home"></i> Back to Website
            </a>
            <a href="db_quick_ref.php" class="btn btn-primary" style="padding: 15px; text-align: center;">
                <i class="fas fa-book"></i> Quick Reference
            </a>
            <a href="DB_README.md" class="btn btn-secondary" style="padding: 15px; text-align: center;">
                <i class="fas fa-file"></i> README
            </a>
            <a href="SETUP_GUIDE.md" class="btn btn-secondary" style="padding: 15px; text-align: center;">
                <i class="fas fa-file"></i> Setup Guide
            </a>
        </div>
    </div>
</body>
</html>
