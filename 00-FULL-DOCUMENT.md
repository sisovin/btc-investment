# BTC-INVESTMENT: Complete Documentation

## Project Overview

**BTC-INVESTMENT** is a comprehensive High-Yield Investment Program (HYIP) platform converted from a Laravel-based application to a modern native PHP 8.5 MVC architecture. The system provides investment management, user authentication, admin panel, payment processing, and automated investment returns.

### Technology Stack

- **Backend**: Native PHP 8.5
- **Architecture**: MVC (Model-View-Controller)
- **Security**: Argon2id password hashing, JWT authentication
- **Database**: PDO MySQL
- **Caching**: Redis synchronization
- **Frontend**: Tailwind CSS V4
- **CLI**: Native PHP CLI for system commands

### Key Features

- User registration and authentication
- Investment plans and management
- Automated compound interest calculations
- Deposit and withdrawal processing
- Admin dashboard with full management
- Payment gateway integration
- Referral system
- Email/SMS notifications
- Multi-language support
- Responsive design

---

## Project Structure (TREE/F)

```
btc-investment/
├── 00-FULL-DOCUMENT.md          # Complete project documentation
├── README.md                    # Project overview and setup instructions
├── composer.json               # PHP dependencies and autoloading
├── phpunit.xml                # Unit testing configuration
├── .env.example               # Environment variables template
├── .gitignore                 # Git ignore rules
├── tailwind.config.js         # TailwindCSS (CLI) version 4.1.18
├── package.json                # watch & build-css npx @tailwindcss/cli
│
├── app/                        # Application core (MVC)
│   ├── Controllers/            # Controller classes
│   │   ├── Admin/             # Admin panel controllers
│   │   │   ├── AuthController.php         # Admin login/logout
│   │   │   ├── DashboardController.php    # Admin dashboard
│   │   │   ├── UserController.php         # User management
│   │   │   ├── InvestmentController.php   # Investment management
│   │   │   ├── DepositController.php      # Deposit management
│   │   │   ├── WithdrawController.php     # Withdrawal management
│   │   │   ├── PlanController.php         # Investment plans
│   │   │   ├── SettingController.php      # System settings
│   │   │   ├── ReportController.php       # Reports and analytics
│   │   │   └── SupportController.php      # Support ticket management
│   │   ├── User/               # User panel controllers
│   │   │   ├── AuthController.php         # User login/logout/register
│   │   │   ├── DashboardController.php    # User dashboard
│   │   │   ├── InvestmentController.php   # User investments
│   │   │   ├── DepositController.php      # User deposits
│   │   │   ├── WithdrawController.php     # User withdrawals
│   │   │   ├── ProfileController.php      # User profile management
│   │   │   ├── ReferralController.php     # Referral system
│   │   │   └── SupportController.php      # Support tickets
│   │   ├── Api/                # API controllers
│   │   │   ├── AuthController.php         # JWT authentication
│   │   │   ├── InvestmentController.php   # Investment API
│   │   │   ├── DepositController.php      # Deposit API
│   │   │   └── WithdrawController.php     # Withdrawal API
│   │   └── HomeController.php   # Public pages controller
│   │
│   ├── Models/                 # Data models
│   │   ├── User.php            # User model
│   │   ├── Admin.php           # Admin model
│   │   ├── Investment.php      # Investment model
│   │   ├── Deposit.php         # Deposit model
│   │   ├── Withdraw.php        # Withdrawal model
│   │   ├── Plan.php            # Investment plan model
│   │   ├── PaymentMethod.php   # Payment method model
│   │   ├── Transaction.php     # Transaction model
│   │   ├── Referral.php        # Referral model
│   │   ├── Support.php         # Support ticket model
│   │   ├── Setting.php         # System settings model
│   │   ├── Compound.php        # Compound interest model
│   │   ├── Faq.php             # FAQ model
│   │   ├── Page.php            # CMS page model
│   │   ├── Menu.php            # Menu model
│   │   ├── Slider.php          # Slider model
│   │   ├── Service.php         # Service model
│   │   ├── Testimonial.php     # Testimonial model
│   │   └── Social.php          # Social media model
│   │
│   ├── Views/                  # Template files
│   │   ├── layouts/            # Layout templates
│   │   │   ├── admin.php       # Admin layout
│   │   │   ├── user.php        # User layout
│   │   │   └── public.php      # Public layout
│   │   ├── admin/              # Admin templates
│   │   │   ├── auth/           # Admin authentication
│   │   │   ├── dashboard/      # Admin dashboard
│   │   │   ├── users/          # User management
│   │   │   ├── investments/    # Investment management
│   │   │   ├── deposits/       # Deposit management
│   │   │   ├── withdrawals/    # Withdrawal management
│   │   │   ├── plans/          # Plan management
│   │   │   ├── settings/       # Settings management
│   │   │   ├── reports/        # Reports
│   │   │   └── support/        # Support tickets
│   │   ├── user/               # User templates
│   │   │   ├── auth/           # User authentication
│   │   │   ├── dashboard/      # User dashboard
│   │   │   ├── investments/    # User investments
│   │   │   ├── deposits/       # User deposits
│   │   │   ├── withdrawals/    # User withdrawals
│   │   │   ├── profile/        # User profile
│   │   │   ├── referrals/      # Referral system
│   │   │   └── support/        # Support tickets
│   │   ├── public/             # Public templates
│   │   │   ├── home.php        # Homepage
│   │   │   ├── about.php       # About page
│   │   │   ├── faqs.php        # FAQ page
│   │   │   ├── contact.php     # Contact page
│   │   │   ├── plans.php       # Investment plans
│   │   │   └── services.php    # Services page
│   │   ├── emails/             # Email templates
│   │   ├── partials/           # Reusable components
│   │   └── errors/             # Error pages
│   │
│   └── Core/                   # Core application classes
│       ├── Database.php        # PDO database wrapper
│       ├── Auth.php            # Authentication handler
│       ├── JWT.php             # JWT token management
│       ├── Redis.php           # Redis cache wrapper
│       ├── Router.php          # URL routing
│       ├── Controller.php      # Base controller
│       ├── Model.php           # Base model
│       ├── View.php            # Template engine
│       ├── Session.php         # Session management
│       ├── Validator.php       # Input validation
│       ├── Mailer.php          # Email sending
│       ├── SMS.php             # SMS sending
│       ├── Payment.php         # Payment processing
│       ├── Security.php        # Security utilities
│       ├── Logger.php          # Logging system
│       └── Helper.php          # Utility functions
│
├── public/                     # Web root directory
│   ├── index.php               # Application entry point
│   ├── .htaccess               # Apache configuration
│   ├── robots.txt              # Search engine crawling
│   ├── favicon.ico             # Website favicon
│   └── assets/                 # Static assets
│       ├── css/                # Stylesheets
│       │   ├── app.css         # Main application styles
│       │   ├── admin.css       # Admin panel styles
│       │   └── tailwind.css    # Tailwind CSS framework
│       ├── js/                 # JavaScript files
│       │   ├── app.js          # Main application scripts
│       │   ├── admin.js        # Admin panel scripts
│       │   ├── chart.js        # Chart libraries
│       │   └── validation.js   # Form validation
│       └── images/             # Image assets
│           ├── logo/           # Logo files
│           ├── icons/          # Icon files
│           ├── sliders/        # Slider images
│           └── uploads/        # User uploaded files
│
├── cli/                        # Command Line Interface
│   ├── btc-cli.php             # CLI entry point
│   └── commands/               # CLI commands
│       ├── GenerateReturns.php # Generate investment returns
│       ├── ProcessDeposits.php # Process pending deposits
│       ├── ProcessWithdrawals.php # Process withdrawal requests
│       ├── SendNotifications.php # Send email/SMS notifications
│       ├── BackupDatabase.php  # Database backup
│       ├── ClearCache.php      # Clear Redis cache
│       └── UpdateExchangeRates.php # Update crypto rates
│
├── config/                     # Configuration files
│   ├── app.php                 # Application configuration
│   ├── database.php            # Database configuration
│   ├── redis.php               # Redis configuration
│   ├── jwt.php                 # JWT configuration
│   ├── mail.php                # Email configuration
│   ├── sms.php                 # SMS configuration
│   ├── payment.php             # Payment gateway config
│   └── security.php            # Security settings
│
├── database/                   # Database related files
│   ├── migrations/             # Database migrations
│   │   ├── 001_create_users_table.php
│   │   ├── 002_create_admins_table.php
│   │   ├── 003_create_investments_table.php
│   │   ├── 004_create_deposits_table.php
│   │   ├── 005_create_withdrawals_table.php
│   │   ├── 006_create_plans_table.php
│   │   ├── 007_create_transactions_table.php
│   │   ├── 008_create_referrals_table.php
│   │   ├── 009_create_support_tickets_table.php
│   │   └── 010_create_settings_table.php
│   └── seeds/                  # Database seeders
│       ├── AdminSeeder.php     # Admin user seeder
│       ├── PlanSeeder.php      # Investment plans seeder
│       ├── SettingSeeder.php   # System settings seeder
│       └── UserSeeder.php      # Test users seeder
│
├── logs/                       # Application logs
│   ├── app.log                 # General application logs
│   ├── error.log               # Error logs
│   ├── auth.log                # Authentication logs
│   ├── payment.log             # Payment processing logs
│   └── cron.log                # Cron job logs
│
├── storage/                    # File storage
│   ├── cache/                  # Cache files
│   ├── sessions/               # Session files
│   ├── uploads/                # User uploads
│   └── temp/                   # Temporary files
│
├── tests/                      # Unit and feature tests
│   ├── Unit/                   # Unit tests
│   │   ├── Controllers/        # Controller tests
│   │   ├── Models/             # Model tests
│   │   └── Core/               # Core class tests
│   ├── Feature/                # Feature tests
│   │   ├── AuthTest.php        # Authentication tests
│   │   ├── InvestmentTest.php  # Investment tests
│   │   ├── DepositTest.php     # Deposit tests
│   │   └── WithdrawalTest.php  # Withdrawal tests
│   ├── TestCase.php            # Base test case
│   └── bootstrap.php           # Test bootstrap
│
└── vendor/                     # Composer dependencies
    ├── autoload.php            # Composer autoloader
    ├── bin/                    # Executable scripts
    ├── composer/               # Composer files
    ├── predis/                 # Redis client
    ├── firebase/               # JWT library
    └── other-dependencies/     # Other packages
```

---

## Core Architecture

### MVC Pattern Implementation

The application follows the Model-View-Controller architectural pattern:

- **Models**: Handle data logic and database interactions
- **Views**: Manage presentation layer and user interface
- **Controllers**: Process user input and coordinate between models and views

### Security Features

- **Argon2id Password Hashing**: Industry-standard password hashing
- **JWT Authentication**: Secure token-based authentication for APIs
- **CSRF Protection**: Cross-site request forgery prevention
- **XSS Prevention**: Cross-site scripting protection
- **SQL Injection Prevention**: PDO prepared statements
- **Rate Limiting**: API rate limiting with Redis
- **Input Validation**: Comprehensive input sanitization

### Database Design

The system uses MySQL with the following main tables:

#### Core Tables

- `users` - User accounts and profiles
- `admins` - Administrative accounts
- `investments` - User investment records
- `deposits` - Deposit transactions
- `withdrawals` - Withdrawal requests
- `plans` - Investment plan configurations
- `transactions` - All financial transactions
- `settings` - System configuration

#### Supporting Tables

- `payment_methods` - Available payment options
- `referrals` - Referral system data
- `support_tickets` - Customer support
- `faqs` - Frequently asked questions
- `pages` - CMS pages
- `menus` - Navigation menus
- `sliders` - Homepage sliders
- `services` - Service descriptions
- `testimonials` - User testimonials
- `social_links` - Social media links

---

## Installation & Setup

### Prerequisites

- PHP 8.5 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Redis 6.0+
- Composer
- Node.js & npm (for frontend assets)
- Apache/Nginx web server

### Installation Steps

1. **Clone Repository**

   ```bash
   git clone https://github.com/sisovin/btc-investment.git
   cd btc-investment
   ```

2. **Install Dependencies**

   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**

   ```bash
   cp .env.example .env
   # Edit .env with your database and other settings
   ```

4. **Database Setup**

   ```bash
   # Create database
   mysql -u root -p -e "CREATE DATABASE btc_investment"

   # Run migrations
   php cli/btc-cli.php migrate

   # Seed database
   php cli/btc-cli.php seed
   ```

5. **Build Assets**

   ```bash
   npm run build
   ```

6. **Web Server Configuration**
   - Point document root to `public/` directory
   - Ensure `storage/` and `logs/` are writable
   - Configure URL rewriting

7. **Cron Jobs Setup**

   ```bash
   # Add to crontab for automated tasks
   * * * * * php /path/to/btc-investment/cli/btc-cli.php cron:returns
   0 * * * * php /path/to/btc-investment/cli/btc-cli.php cron:notifications
   ```

---

## API Documentation

### Authentication

The API uses JWT (JSON Web Tokens) for authentication.

#### Login

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

#### Response

```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com"
  }
}
```

### Investment Endpoints

#### Get User Investments

```http
GET /api/investments
Authorization: Bearer {token}
```

#### Create Investment

```http
POST /api/investments
Authorization: Bearer {token}
Content-Type: application/json

{
  "plan_id": 1,
  "amount": 1000
}
```

#### Get Investment Details

```http
GET /api/investments/{id}
Authorization: Bearer {token}
```

### Deposit Endpoints

#### Create Deposit

```http
POST /api/deposits
Authorization: Bearer {token}
Content-Type: application/json

{
  "amount": 500,
  "payment_method_id": 1
}
```

#### Get Deposit History

```http
GET /api/deposits
Authorization: Bearer {token}
```

### Withdrawal Endpoints

#### Request Withdrawal

```http
POST /api/withdrawals
Authorization: Bearer {token}
Content-Type: application/json

{
  "amount": 200,
  "payment_method_id": 1
}
```

#### Get Withdrawal History

```http
GET /api/withdrawals
Authorization: Bearer {token}
```

---

## CLI Commands

The application includes a comprehensive CLI tool for system management.

### Usage

```bash
php cli/btc-cli.php <command> [options]
```

### Available Commands

#### Investment Management

```bash
# Generate investment returns
php cli/btc-cli.php returns:generate

# Process compound interest
php cli/btc-cli.php compound:process
```

#### Payment Processing

```bash
# Process pending deposits
php cli/btc-cli.php deposits:process

# Process withdrawal requests
php cli/btc-cli.php withdrawals:process
```

#### System Maintenance

```bash
# Clear Redis cache
php cli/btc-cli.php cache:clear

# Backup database
php cli/btc-cli.php db:backup

# Send notifications
php cli/btc-cli.php notifications:send
```

#### Development

```bash
# Create new migration
php cli/btc-cli.php make:migration create_table_name

# Create new model
php cli/btc-cli.php make:model ModelName

# Create new controller
php cli/btc-cli.php make:controller ControllerName
```

---

## Configuration

### Environment Variables

Create a `.env` file in the root directory:

```env
# Application
APP_NAME=BTC-INVESTMENT
APP_ENV=production
APP_KEY=your-secret-key
APP_URL=https://your-domain.com

# Database
DB_HOST=localhost
DB_PORT=3306
DB_NAME=btc_investment
DB_USER=your_db_user
DB_PASS=your_db_password

# Redis
REDIS_HOST=localhost
REDIS_PORT=6379
REDIS_PASSWORD=

# JWT
JWT_SECRET=your-jwt-secret
JWT_EXPIRE=3600

# Email
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# SMS (if applicable)
SMS_API_KEY=your-sms-api-key
SMS_SENDER_ID=your-sender-id

# Payment Gateways
PAYPAL_CLIENT_ID=your-paypal-client-id
PAYPAL_CLIENT_SECRET=your-paypal-secret
STRIPE_PUBLISHABLE_KEY=your-stripe-pub-key
STRIPE_SECRET_KEY=your-stripe-secret

# Security
ARGON2ID_MEMORY_COST=65536
ARGON2ID_TIME_COST=4
ARGON2ID_THREADS=3
```

### Database Configuration

Located in `config/database.php`:

```php
return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 3306),
            'database' => env('DB_NAME', 'btc_investment'),
            'username' => env('DB_USER', 'root'),
            'password' => env('DB_PASS', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]
    ]
];
```

### Redis Configuration

Located in `config/redis.php`:

```php
return [
    'host' => env('REDIS_HOST', 'localhost'),
    'port' => env('REDIS_PORT', 6379),
    'password' => env('REDIS_PASSWORD'),
    'database' => 0,
    'prefix' => 'btc_investment:',
];
```

---

## Security Implementation

### Password Security

The application uses Argon2id for password hashing, which is the winner of the Password Hashing Competition and recommended by OWASP.

```php
// Password hashing
$hash = password_hash($password, PASSWORD_ARGON2ID, [
    'memory_cost' => 65536,
    'time_cost' => 4,
    'threads' => 3
]);

// Password verification
if (password_verify($password, $hash)) {
    // Password is correct
}
```

### JWT Authentication

JSON Web Tokens are used for API authentication and session management.

```php
// Generate JWT token
$token = JWT::encode([
    'user_id' => $user->id,
    'exp' => time() + 3600
], $secret);

// Verify JWT token
try {
    $decoded = JWT::decode($token, $secret, ['HS256']);
} catch (Exception $e) {
    // Token is invalid
}
```

### Input Validation

All user inputs are validated and sanitized:

```php
$validator = new Validator();
$rules = [
    'email' => 'required|email',
    'password' => 'required|min:8',
    'amount' => 'required|numeric|min:1'
];

if (!$validator->validate($_POST, $rules)) {
    $errors = $validator->getErrors();
}
```

### CSRF Protection

Cross-site request forgery protection using tokens:

```php
// Generate CSRF token
$token = Security::generateCSRFToken();

// Verify CSRF token
if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
    die('CSRF token validation failed');
}
```

---

## Database Schema

### Users Table

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    balance DECIMAL(15,2) DEFAULT 0,
    referral_code VARCHAR(50) UNIQUE,
    referrer_id INT,
    email_verified_at TIMESTAMP NULL,
    phone_verified_at TIMESTAMP NULL,
    status ENUM('active', 'inactive', 'banned') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (referrer_id) REFERENCES users(id)
);
```

### Investments Table

```sql
CREATE TABLE investments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    profit DECIMAL(15,2) DEFAULT 0,
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP NULL,
    last_profit_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (plan_id) REFERENCES plans(id)
);
```

### Deposits Table

```sql
CREATE TABLE deposits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    transaction_id VARCHAR(255) UNIQUE NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    charge DECIMAL(10,2) DEFAULT 0,
    net_amount DECIMAL(15,2) NOT NULL,
    payment_method_id INT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    proof_image VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id)
);
```

### Withdrawals Table

```sql
CREATE TABLE withdrawals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    charge DECIMAL(10,2) DEFAULT 0,
    net_amount DECIMAL(15,2) NOT NULL,
    payment_method_id INT NOT NULL,
    wallet_address VARCHAR(255) NULL,
    status ENUM('pending', 'approved', 'rejected', 'paid') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id)
);
```

### Plans Table

```sql
CREATE TABLE plans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    min_amount DECIMAL(15,2) NOT NULL,
    max_amount DECIMAL(15,2) NULL,
    interest_rate DECIMAL(5,2) NOT NULL,
    compound_frequency ENUM('hourly', 'daily', 'weekly', 'monthly') NOT NULL,
    duration_days INT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## Frontend Implementation

### Tailwind CSS V4

The application uses Tailwind CSS V4 for styling with a custom design system.

#### Main Stylesheet (`public/assets/css/app.css`)

```css
@import "tailwindcss";

@theme {
  --color-primary: #2563eb;
  --color-secondary: #64748b;
  --color-success: #10b981;
  --color-warning: #f59e0b;
  --color-danger: #ef4444;
}

.btn-primary {
  @apply bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors;
}

.card {
  @apply bg-white rounded-lg shadow-md p-6;
}
```

#### JavaScript Implementation

The frontend uses vanilla JavaScript with modern ES6+ features.

#### Main JavaScript (`public/assets/js/app.js`)

```javascript
// Investment calculator
class InvestmentCalculator {
    constructor() {
        this.planSelect = document.getElementById('plan-select');
        this.amountInput = document.getElementById('amount-input');
        this.resultDiv = document.getElementById('calculator-result');

        this.init();
    }

    init() {
        this.planSelect.addEventListener('change', () => this.calculate());
        this.amountInput.addEventListener('input', () => this.calculate());
    }

    calculate() {
        const planId = this.planSelect.value;
        const amount = parseFloat(this.amountInput.value);

        if (!planId || !amount) return;

        fetch(`/api/calculate-profit`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.getToken()}`
            },
            body: JSON.stringify({ plan_id: planId, amount: amount })
        })
        .then(response => response.json())
        .then(data => {
            this.displayResult(data);
        })
        .catch(error => {
            console.error('Calculation error:', error);
        });
    }

    displayResult(data) {
        this.resultDiv.innerHTML = `
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-green-800">Profit Calculation</h3>
                <p class="text-green-600">Daily Profit: $${data.daily_profit}</p>
                <p class="text-green-600">Monthly Profit: $${data.monthly_profit}</p>
                <p class="text-green-600">Total Return: $${data.total_return}</p>
            </div>
        `;
    }

    getToken() {
        return localStorage.getItem('jwt_token');
    }
}

// Initialize calculator when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new InvestmentCalculator();
});
```

---

## Testing

### Unit Tests

Located in `tests/Unit/`:

```php
<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Core\Database;

class UserTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        $this->db = new Database();
        // Set up test database
    }

    public function testUserCreation()
    {
        $user = new User();
        $user->name = 'Test User';
        $user->email = 'test@example.com';
        $user->password = 'password123';

        $result = $user->save();

        $this->assertTrue($result);
        $this->assertGreaterThan(0, $user->id);
    }

    public function testUserAuthentication()
    {
        $user = User::findByEmail('test@example.com');

        $this->assertNotNull($user);
        $this->assertEquals('Test User', $user->name);
    }
}
```

### Feature Tests

Located in `tests/Feature/`:

```php
<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\Api\AuthController;

class AuthTest extends TestCase
{
    public function testUserLogin()
    {
        $controller = new AuthController();

        $response = $controller->login([
            'email' => 'user@example.com',
            'password' => 'password123'
        ]);

        $this->assertArrayHasKey('token', $response);
        $this->assertArrayHasKey('user', $response);
    }

    public function testInvalidLogin()
    {
        $controller = new AuthController();

        $response = $controller->login([
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword'
        ]);

        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('Invalid credentials', $response['error']);
    }
}
```

### Running Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test file
vendor/bin/phpunit tests/Unit/Models/UserTest.php

# Run with coverage
vendor/bin/phpunit --coverage-html coverage/
```

---

## Deployment

### Production Deployment

1. **Server Requirements**
   - PHP 8.5+
   - MySQL 8.0+
   - Redis 6.0+
   - SSL certificate
   - Cron daemon

2. **Deployment Steps**

   ```bash
   # Clone to production server
   git clone https://github.com/your-repo/btc-investment.git /var/www/btc-investment

   # Install dependencies
   cd /var/www/btc-investment
   composer install --no-dev --optimize-autoloader
   npm install && npm run build

   # Set up environment
   cp .env.example .env
   # Edit .env with production values

   # Set permissions
   chown -R www-data:www-data .
   chmod -R 755 storage/
   chmod -R 755 logs/

   # Run migrations
   php cli/btc-cli.php migrate

   # Set up cron jobs
   crontab -e
   # Add: * * * * * php /var/www/btc-investment/cli/btc-cli.php cron:returns
   ```

3. **Web Server Configuration (Apache)**

   ```apache
   <VirtualHost *:80>
       ServerName your-domain.com
       DocumentRoot /var/www/btc-investment/public

       <Directory /var/www/btc-investment/public>
           AllowOverride All
           Require all granted
       </Directory>

       ErrorLog ${APACHE_LOG_DIR}/btc-investment_error.log
       CustomLog ${APACHE_LOG_DIR}/btc-investment_access.log combined
   </VirtualHost>
   ```

4. **Web Server Configuration (Nginx)**

   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/btc-investment/public;

       index index.php;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           include snippets/fastcgi-php.conf;
           fastcgi_pass unix:/var/run/php/php8.5-fpm.sock;
       }

       location ~ /\.ht {
           deny all;
       }
   }
   ```

### SSL Configuration

```nginx
server {
    listen 443 ssl http2;
    server_name your-domain.com;

    ssl_certificate /path/to/ssl/cert.pem;
    ssl_certificate_key /path/to/ssl/private.key;

    # ... rest of configuration
}
```

### Monitoring & Maintenance

1. **Log Monitoring**

   ```bash
   # Monitor error logs
   tail -f logs/error.log

   # Monitor application logs
   tail -f logs/app.log
   ```

2. **Performance Monitoring**
   - Set up New Relic or similar APM
   - Monitor Redis memory usage
   - Database query performance
   - API response times

3. **Backup Strategy**

   ```bash
   # Daily database backup
   0 2 * * * mysqldump btc_investment > /backups/db_$(date +\%Y\%m\%d).sql

   # Weekly file backup
   0 3 * * 0 tar -czf /backups/files_$(date +\%Y\%m\%d).tar.gz /var/www/btc-investment
   ```

---

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check database credentials in `.env`
   - Ensure MySQL service is running
   - Verify database exists

2. **Redis Connection Failed**
   - Check Redis configuration
   - Ensure Redis service is running
   - Verify firewall settings

3. **File Upload Issues**
   - Check `storage/` permissions
   - Verify PHP upload settings
   - Check disk space

4. **Email Not Sending**
   - Verify SMTP credentials
   - Check mail server logs
   - Test with different email provider

### Debug Mode

Enable debug mode in `.env`:

```env
APP_DEBUG=true
```

This will show detailed error messages and stack traces.

### Logging

All errors and important events are logged to `logs/` directory:

- `app.log` - General application logs
- `error.log` - PHP errors and exceptions
- `auth.log` - Authentication attempts
- `payment.log` - Payment processing logs

---

## Contributing

### Development Setup

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write tests for new features
5. Ensure all tests pass
6. Submit a pull request

### Code Standards

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add PHPDoc comments for all classes and methods
- Write comprehensive unit tests
- Keep functions small and focused

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/new-feature

# Make changes and commit
git add .
git commit -m "Add new feature"

# Push to your fork
git push origin feature/new-feature

# Create pull request
```

---

## License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## Support

For support and questions:

- **Documentation**: [Full Documentation](00-FULL-DOCUMENT.md)
- **Issues**: [GitHub Issues](https://github.com/your-repo/btc-investment/issues)
- **Email**: <support@btc-investment.com>
- **Forum**: [Community Forum](https://forum.btc-investment.com)

---

## Changelog

### Version 2.0.0 (Current)

- Converted from Laravel to native PHP 8.5 MVC
- Implemented Argon2id password hashing
- Added JWT authentication
- Integrated Redis caching
- Updated to Tailwind CSS V4
- Added comprehensive CLI tools
- Improved security features
- Enhanced API endpoints

### Version 1.0.0 (Legacy)

- Initial Laravel-based implementation
- Basic HYIP functionality
- Admin and user panels
- Payment processing
- Investment management

---

*This documentation is automatically generated and maintained. Last updated: February 11, 2026*
