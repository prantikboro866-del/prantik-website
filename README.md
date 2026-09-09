# Prantik's Portfolio Website

## Setup Instructions

### 1. Start XAMPP
- Open XAMPP Control Panel
- Start Apache and MySQL services

### 2. Database Setup
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Navigate to the website root in browser: `http://localhost/prantik-website`
3. The database will be automatically created on first load via `db_init.php`

### 3. Login Credentials (Demo Account)
- **Email:** prantikboro369@gmail.com
- **Password:** password123

### 4. Features
- **User Authentication:** Register, Login, Logout with secure password hashing
- **User Profiles:** Update personal information
- **Contact Form:** Messages saved to database
- **Dark Mode:** Theme toggle with localStorage persistence
- **Responsive Design:** Mobile-friendly interface
- **Social Media Integration:** Links to all social profiles

### 5. File Structure
```
prantik-website/
├── config.php           # Database configuration
├── db_init.php          # Database initialization
├── index.php            # Homepage
├── register.php         # Registration page
├── login.php            # Login page
├── profile.php          # User profile
├── about.php            # About page
├── contact.php          # Contact page
├── media.php            # Media resources
├── logout.php           # Logout handler
├── process_contact.php  # Contact form processor
├── assets/
│   ├── styles.css       # Main stylesheet
│   └── main.js          # JavaScript functionality
└── README.md            # This file
```

### 6. Database Tables
- **users** - User account information
- **messages** - Contact form messages
- **contacts** - User contacts (extensible)

### 7. Security Features
- Password hashing with bcrypt
- SQL prepared statements (prevent SQL injection)
- Session management
- Input validation and sanitization
- CSRF protection (can be enhanced)

### 8. Access the Site
```
http://localhost/prantik-website/
```

### 9. Admin Features (Optional Enhancement)
You can create an admin panel to:
- View all contact messages
- Manage user accounts
- View analytics

Enjoy your portfolio website!
