# My Database 2FA Demo

This project is a small PHP/MySQL demonstration of user registration and two-factor authentication (2FA). It shows a basic flow where a user registers, logs in, receives a one-time code by email, and then verifies that code before access is granted.

## What the project does

The application includes:

- A simple registration form that stores new users in a MySQL database
- Password hashing using PHP's built-in password functions
- A login flow that generates a 6-digit 2FA code
- Email delivery of the 2FA code using PHP's mail function
- A verification step for the code
- A page that displays registered users

## Project files

- [index.html](index.html) - Registration form page
- [register.php](register.php) - Handles user registration
- [user.php](user.php) - Handles login and sends the 2FA code
- [verify_2fa.php](verify_2fa.php) - Verifies the entered 2FA code
- [display_users.php](display_users.php) - Displays registered users
- [Database.php](Database.php) - Contains the database connection logic

## Technologies used

- PHP
- MySQL
- PDO
- HTML

## Setup

1. Make sure you have a local web server running with PHP and MySQL.
2. Create a MySQL database named `my_database`.
3. Create a `users` table with a structure similar to this:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Update the database connection settings in [Database.php](Database.php) if needed.
5. Place the project in your web server directory and open [index.html](index.html) in a browser.

## How it works

1. Open [index.html](index.html) and register a new account.
2. The registration form sends the data to [register.php](register.php).
3. The user then logs in through [user.php](user.php), which generates a 2FA code and sends it to the email address.
4. The user enters that code in [verify_2fa.php](verify_2fa.php) to complete authentication.
5. [display_users.php](display_users.php) can be used to view the registered users.

## Notes

- This is a basic demo project and is not intended for production use as-is.
- The email delivery depends on PHP mail configuration on your server.
- Some parts of the project may need small fixes or refinements depending on your local environment.

## License

This project is provided for learning and demonstration purposes.
