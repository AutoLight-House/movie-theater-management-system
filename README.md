# Movie Booking System

A comprehensive PHP-based movie booking system with admin panel and user interface for managing movie theaters, showtimes, and ticket bookings.

## 🎬 Features

### User Features
- **User Registration & Login**: Secure user authentication system
- **Theater Selection**: Choose from multiple theater locations
- **Movie Browsing**: View available movies with details, trailers, and ratings
- **Booking System**: Book tickets for specific dates and times
- **Seat Selection**: Choose from different seat classes (Silver, Gold, Platinum)
- **Booking History**: View past and current bookings
- **Responsive Design**: Mobile-friendly interface

### Admin Features
- **Admin Dashboard**: Complete control panel for system management
- **Theater Management**: Add, edit, and delete theater locations
- **Movie Management**: Manage movie listings with descriptions, trailers, and ratings
- **Showtime Management**: Schedule movie showtimes for different dates
- **User Management**: View and manage registered users
- **Booking Management**: View and manage all bookings
- **Real-time Updates**: Dynamic content management

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- PDO extension enabled

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/movie-booking-system.git
   cd movie-booking-system/phpproj
   ```

2. **Set up the database**
   - Create a MySQL database named `mirai`
   - Import the new clean database schema:
   ```bash
   mysql -u root -p mirai < database_schema.sql
   ```

3. **Run the installer (Alternative)**
   - Navigate to `http://localhost/movie-booking-system/phpproj/install.php`
   - Follow the installation wizard
   - Configure your database settings

4. **Migration (If upgrading from old version)**
   - If you have an existing database with old field names, run:
   - Navigate to `http://localhost/movie-booking-system/phpproj/migrate.php`
   - Follow the migration wizard to update your database

5. **Access the application**
   - **Admin Panel**: `http://localhost/movie-booking-system/phpproj/admin/`
     - Username: `admin`
     - Password: `admin123`
   - **User Interface**: `http://localhost/movie-booking-system/phpproj/user/`

## 📁 Project Structure

```
phpproj/
├── index.php              # Main landing page
├── install.php            # Installation wizard
├── migrate.php            # Database migration tool
├── config.php             # Centralized configuration
├── maintenance.php        # Database maintenance
├── database_schema.sql    # Clean database schema (recommended)
├── mirai.sql              # Legacy database schema
├── includes/              # Helper functions and security
├── templates/             # Error pages and templates
├── logs/                  # Application logs
├── backups/               # Database backups
├── admin/                 # Admin panel files
├── user/                  # User interface files
├── README.md              # Comprehensive documentation
├── DEPLOYMENT.md          # Production deployment guide
├── CHANGELOG.md           # Version history
├── .env.example           # Environment template
└── .gitignore             # Git ignore file
```

## 🗃️ Database Schema

### Main Tables
- **users**: User account information with secure authentication
- **admins**: Administrator accounts with enhanced permissions
- **movie_theatres**: Theater locations with detailed information
- **bookings**: Ticket booking records with payment tracking
- **[theater]_[movie]_timing**: Dynamic tables for showtimes
- **activity_logs**: Security and audit trail logging
- **user_sessions**: Secure session management
- **system_settings**: Application configuration
- **movie_genres**: Movie categorization

### Key Features of Database Design
- Normalized structure for efficient data storage
- Dynamic table creation for theater-specific showtimes
- Secure password hashing with bcrypt
- Comprehensive indexing for performance
- Foreign key constraints for data integrity
- Audit trails for security monitoring
- Clean, professional field naming conventions

## 🔧 Configuration

### Database Configuration
Edit `config.php` to match your database settings:

```php
$host = 'localhost';
$dbname = 'mirai';
$username = 'root';
$password = '';
```

### Security Features
- **Password Hashing**: All passwords are securely hashed using PHP's `password_hash()`
- **Prepared Statements**: Protection against SQL injection
- **Session Management**: Secure user session handling
- **Input Sanitization**: XSS prevention through input/output sanitization

## 🎯 Usage Guide

### For Users
1. **Registration**: Create an account with your details
2. **Login**: Access your account
3. **Select Theater**: Choose your preferred theater location
4. **Browse Movies**: View available movies with details
5. **Book Tickets**: Select date, time, and seat class
6. **View Bookings**: Check your booking history

### For Administrators
1. **Login**: Access admin panel with admin credentials
2. **Manage Theaters**: Add new theater locations
3. **Manage Movies**: Add movies with details, trailers, and ratings
4. **Schedule Shows**: Set up showtimes for movies
5. **View Bookings**: Monitor all customer bookings
6. **User Management**: Oversee registered users

## 🛠️ Development

### File Organization
- **Modular Design**: Separate modules for user and admin functionality
- **Reusable Components**: Common functions and database connections
- **Clean Code**: Well-commented and structured PHP code

### Adding New Features
1. Follow the existing file structure
2. Use the established database connection methods
3. Implement proper error handling
4. Add security measures for user input

## 🔒 Security Considerations

- Change default admin password after installation
- Use HTTPS in production
- Regular database backups
- Keep PHP and MySQL updated
- Implement proper file permissions

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check database credentials in `config.php`
   - Ensure MySQL service is running
   - Verify database exists

2. **Permission Denied**
   - Check file permissions for uploads directory
   - Ensure web server has read/write access

3. **Session Issues**
   - Verify session directory permissions
   - Check PHP session configuration

## 📝 API Documentation

### Core Functions

- `sanitize_output($data)`: Prevents XSS attacks
- `sanitize_input($data)`: Cleans user input
- Session management functions
- Database connection handling

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 📞 Support

For support and questions:
- Create an issue in the repository

## 🔄 Updates

### Version 1.0
- Initial release with core functionality
- User registration and authentication
- Movie booking system
- Admin panel for management

---

**Note**: This is an educational project developed for learning purposes. Please ensure proper security measures are implemented before using in a production environment.
