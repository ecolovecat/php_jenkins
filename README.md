# Login System - PHP Best Practices

A secure and well-structured PHP login system following modern PHP best practices.

## Features

- **Secure Authentication**: Password hashing, session management, and CSRF protection
- **Input Validation**: Comprehensive validation and sanitization
- **Error Handling**: Proper exception handling and logging
- **Database Security**: Prepared statements and SQL injection prevention
- **Session Security**: Secure session configuration and management
- **Responsive Design**: Modern CSS with responsive layout
- **MVC Architecture**: Clean separation of concerns
- **Configuration Management**: Centralized configuration system

## Security Features

- CSRF token protection
- Password hashing with PHP's `password_hash()`
- Session fixation protection
- Input sanitization and validation
- SQL injection prevention with prepared statements
- Secure session cookie settings
- Error logging without exposing sensitive information

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. **Clone or download the project**

   ```bash
   git clone <repository-url>
   cd LoginSystem
   ```

2. **Database Setup**

   - Create a MySQL database
   - Import the database schema:

   ```sql
   mysql -u root -p < database_setup.sql
   ```

3. **Configuration**

   - Edit `config/Config.php` to match your database settings:

   ```php
   public const DB_HOST = 'localhost';
   public const DB_USERNAME = 'your_username';
   public const DB_PASSWORD = 'your_password';
   public const DB_NAME = 'login_system';
   ```

4. **File Permissions**

   - Ensure web server has read access to all files
   - Ensure logs directory is writable (if using file logging)

5. **Production Setup**
   - Change `ENVIRONMENT` to `'production'` in `config/Config.php`
   - Set `DEBUG_MODE` to `false`
   - Configure proper error logging

## Usage

1. **Access the application**

   - Navigate to `http://your-domain/LoginSystem/`
   - Default page shows the login form

2. **Registration**

   - Click "Sign up here!" to access registration
   - Enter username, password, confirm password, and email
   - Username: 3-50 characters, letters/numbers/underscores only
   - Password: minimum 6 characters, must contain letters and numbers

3. **Login**

   - Enter username and password
   - Successful login redirects to welcome page

4. **Logout**
   - Click "Logout" button on welcome page
   - Session is completely destroyed

## Project Structure

```
LoginSystem/
├── classes/
│   ├── Response.php          # Response handling class
│   ├── Session.php           # Session management class
│   └── Validator.php         # Input validation class
├── config/
│   ├── Config.php            # Application configuration
│   └── Database.php          # Database connection class
├── controllers/
│   └── AuthController.php    # Authentication controller
├── models/
│   └── User.php              # User model
├── views/
│   ├── login.php             # Login view
│   ├── signup.php            # Registration view
│   └── welcome.php           # Welcome page view
├── database_setup.sql        # Database schema
├── index.php                 # Application entry point
├── style.css                 # Stylesheet
└── README.md                 # This file
```

## Code Quality Features

### Error Handling

- Try-catch blocks for all database operations
- Proper error logging
- User-friendly error messages
- Debug mode for development

### Validation

- Server-side input validation
- CSRF protection
- Email format validation
- Password strength requirements
- Username format validation

### Security

- Password hashing with `PASSWORD_DEFAULT`
- Prepared statements for SQL queries
- Input sanitization
- Session security headers
- Protection against session fixation

### Best Practices

- PSR-style code formatting
- Type declarations
- Dependency injection pattern
- Singleton pattern for database
- MVC architecture
- Configuration management
- Separation of concerns

## Configuration Options

Edit `config/Config.php` to customize:

- Database connection settings
- Password requirements
- Username constraints
- Session configuration
- Environment settings (development/production)
- Debug mode settings

## Development vs Production

### Development Mode

- Error display enabled
- Debug information shown
- Detailed error messages

### Production Mode

- Error display disabled
- Error logging only
- Generic error messages
- Security-focused configuration

## Contributing

1. Follow PSR coding standards
2. Add proper type declarations
3. Include error handling
4. Write secure code
5. Test thoroughly
6. Update documentation

## License

This project is open source. Use at your own risk and ensure proper security measures in production environments.
