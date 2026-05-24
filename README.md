# CandidatureTracker

A personal job search tracking application built with **Laravel**. Centralize your job applications, schedule interviews, and maintain a complete history of your recruitment pipeline.

![Status](https://img.shields.io/badge/status-In%20Development-orange)
![License](https://img.shields.io/badge/license-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-11-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Testing](#testing)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Architecture & Design](#architecture--design)
- [Key Technical Decisions](#key-technical-decisions)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

**CandidatureTracker** solves a critical problem for job seekers: managing the overwhelming volume of job applications, interview schedules, and recruiter communications.

Instead of scattered notes and forgotten follow-ups, CandidatureTracker provides:
- **Centralized tracking** of all job applications
- **Interview pipeline management** with scheduling
- **Complete audit trail** of interactions and outcomes
- **Archive system** that preserves history without clutter

Perfect for recent graduates, career changers, and anyone managing multiple job searches across different companies and agencies.

---

## Features

### Core Features ✅

#### 🔐 Authentication
- User registration with email verification
- Secure login/logout with session management
- Password reset functionality
- Built with Laravel Breeze

#### 📋 Application Management
- **Create** job applications with:
  - Company name
  - Target role
  - Job posting URL (optional)
  - Application status and priority
  - Free-form notes
  - Application date
  - File attachment (CV, cover letter, etc.)

- **List** all active applications with key details at a glance
- **Filter** applications by status and/or priority
- **Edit** application details anytime
- **Archive** completed applications without losing history
- **Restore** archived applications to active list
- **View** full application details with associated interviews

#### 🎤 Interview Management
- **Schedule** interviews for each application:
  - Interview type (phone, technical, first, second, final, etc.)
  - Scheduled date and time
  - Preparation notes (optional)
  - Interview result (passed, failed, pending)

- **Edit** interview details
- **Delete** interviews
- **Track** interview pipeline with status visibility

#### 📁 File Management (Bonus)
- **Attach** documents to applications (PDF, DOCX, etc.)
- **Download** attached files from application details
- **Auto-delete** files when application is permanently deleted
- Secure file storage via Laravel Storage

### Quality Features ✅

- **Zero N+1 Queries** — optimized with eager loading
- **Authorization Policies** — users can only access their own data
- **Comprehensive Testing** — Pest tests covering critical paths
- **Form Validation** — robust validation via Form Request classes
- **CSRF Protection** — all forms protected
- **Soft Deletes** — archive without data loss
- **French Localization** — statuses and priorities displayed in French

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Framework** | Laravel 11 |
| **Language** | PHP 8.2+ |
| **Database** | MySQL 8.0+ / MariaDB 10.3+ |
| **Frontend** | Blade Templates, TailwindCSS, Alpine.js |
| **Authentication** | Laravel Breeze |
| **Testing** | Pest PHP |
| **File Storage** | Laravel Storage (local/cloud) |
| **ORM** | Eloquent |
| **Dev Tools** | Laravel Debugbar, Composer |

---

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2+** ([Download](https://www.php.net/downloads))
  - Required extensions: `OpenSSL`, `PDO`, `Mbstring`, `XML`, `Ctype`, `JSON`
  
- **Composer 2.0+** ([Download](https://getcomposer.org/download/))

- **MySQL 8.0+** or **MariaDB 10.3+** ([Download](https://dev.mysql.com/downloads/mysql/))
  - Or use SQLite for local development

- **Node.js & npm** ([Download](https://nodejs.org/)) — for frontend build tools

- **Git** ([Download](https://git-scm.com/))

### Verify Installation

```bash
php --version
composer --version
mysql --version
npm --version
git --version
```

---

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/candidaturetracker.git
cd candidaturetracker
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

This installs all required Laravel packages and dependencies listed in `composer.lock`.

### Step 3: Copy Environment File

```bash
cp .env.example .env
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

This generates a unique encryption key for your application.

### Step 5: Install Frontend Dependencies

```bash
npm install
npm run build
```

For development with hot reload:
```bash
npm run dev
```

### Step 6: Configure Database (see next section)

See [Database Setup](#database-setup) below.

### Step 7: Run Migrations

```bash
php artisan migrate
```

### Step 8: (Optional) Seed Database

```bash
php artisan db:seed
```

Creates sample data for testing.

### Step 9: Serve the Application

```bash
php artisan serve
```

The application will be available at **http://localhost:8000**

---

## Configuration

### Environment Variables

Edit the `.env` file with your configuration:

```env
# Application
APP_NAME="CandidatureTracker"
APP_ENV=local
APP_KEY=base64:YOUR_KEY_HERE  # Generated by key:generate
APP_DEBUG=true  # Set to false in production
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=candidaturetracker
DB_USERNAME=root
DB_PASSWORD=

# Mail (for password reset emails)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # or your mail service
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@candidaturetracker.test
MAIL_FROM_NAME="CandidatureTracker"

# File Storage
FILESYSTEM_DISK=local  # local or s3

# Session
SESSION_DRIVER=database  # or file
SESSION_LIFETIME=120

# Cache & Queue
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Database Connection Options

#### MySQL
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=candidaturetracker
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### SQLite (Development)
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

Create the SQLite file:
```bash
touch database/database.sqlite
```

### Mail Configuration

For password reset emails, configure your mail service:

**Using Mailtrap.io (Testing)**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=YOUR_MAILTRAP_USERNAME
MAIL_PASSWORD=YOUR_MAILTRAP_PASSWORD
```

**Using Gmail (Production)**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-specific-password
```

### File Storage

Store application files locally or on cloud services:

**Local Storage** (default)
```env
FILESYSTEM_DISK=local
# Files stored in: storage/app/
```

**AWS S3**
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=eu-west-1
AWS_BUCKET=your-bucket
```

---

## Database Setup

### Create Database

```bash
# MySQL
mysql -u root -p
> CREATE DATABASE candidaturetracker;
> EXIT;
```

Or using Laravel:
```bash
php artisan db:create candidaturetracker
```

### Run Migrations

```bash
php artisan migrate
```

This creates all necessary tables:
- `users` — user accounts
- `applications` — job applications (with soft deletes)
- `interviews` — interview records
- `password_reset_tokens` — password reset functionality
- `sessions` — session management

### Migration Details

#### Applications Table
```
Columns: id, user_id, company_name, target_role, job_posting_url, status, priority, notes, application_date, file_path, created_at, updated_at, deleted_at
```

**Statuses** (French): `En attente`, `Présélectionné`, `Entretien`, `Offre`, `Rejeté`

**Priorities** (French): `Basse`, `Moyenne`, `Haute`

#### Interviews Table
```
Columns: id, application_id, type, scheduled_at, preparation_notes, result, created_at, updated_at
```

**Types**: Phone Screen, Technical Test, First Interview, Second Interview, Final Interview

**Results**: Passed, Failed, Pending

### Rollback Migrations

Undo all migrations:
```bash
php artisan migrate:reset
```

Undo specific batch:
```bash
php artisan migrate:rollback
```

Undo and re-run:
```bash
php artisan migrate:refresh
php artisan migrate:refresh --seed  # With seeding
```

---

## Testing

### Run All Tests

```bash
php artisan test
```

### Run Specific Test File

```bash
php artisan test tests/Feature/AuthenticationTest.php
```

### Run with Coverage

```bash
php artisan test --coverage
```

### Test Categories

#### Authentication Tests
- User registration with valid/invalid data
- User login with correct/incorrect credentials
- Logout functionality
- Password reset flow

**File:** `tests/Feature/AuthenticationTest.php`

#### Application Management Tests
- Create application with valid data
- Create application with invalid data
- Edit application
- Archive/restore application
- Unauthorized access blocked by Policy
- User isolation (can't access others' applications)

**File:** `tests/Feature/ApplicationTest.php`

#### Interview Management Tests
- Create interview
- Edit interview
- Delete interview
- Authorization checks

**File:** `tests/Feature/InterviewTest.php`

#### Database Tests
- N+1 query verification
- Soft delete functionality
- Relationship integrity

**File:** `tests/Feature/DatabaseTest.php`

### Test Utilities

View test database queries with Debugbar during test:
```bash
php artisan test --env=testing
```

---

## Usage

### 1. Register & Login

1. Navigate to `http://localhost:8000`
2. Click "Register"
3. Enter email and password
4. Click "Sign up"
5. You're automatically logged in

### 2. View Applications

- **Dashboard** shows all active applications
- Key details: Company, Role, Status, Priority, Date
- Click application to view full details

### 3. Create Application

1. Click "New Application" button
2. Fill in:
   - **Company Name** (required) — e.g., "Google"
   - **Target Role** (required) — e.g., "Senior Software Engineer"
   - **Job Posting URL** (optional) — direct link to job posting
   - **Status** (required) — select from dropdown
   - **Priority** (required) — Basse/Moyenne/Haute (Low/Medium/High)
   - **Notes** (optional) — free-form observations
   - **Application Date** (required) — when you applied
   - **File** (optional) — attach CV or cover letter
3. Click "Save Application"

### 4. Schedule Interviews

1. Open application details
2. Click "Add Interview"
3. Fill in:
   - **Type** (required) — Phone, Technical, etc.
   - **Date & Time** (required) — when interview is scheduled
   - **Preparation Notes** (optional) — what to prepare
   - **Result** (optional) — can update later
4. Click "Add"
5. Interview appears in interview list

### 5. Edit Application

1. Open application
2. Click "Edit" button
3. Modify any details
4. Click "Update"

### 6. Archive Application

1. Open completed application
2. Click "Archive" button
3. Confirm in dialog
4. Application moves to archive (not visible in main list)

### 7. View Archives

1. Click "Archives" in navigation
2. View all archived applications
3. Click application to restore

### 8. Filter Applications

1. Go to Applications list
2. Use filter dropdowns:
   - **Status** — filter by status
   - **Priority** — filter by priority
   - Use both together to narrow results
3. Click "Clear Filters" to reset

### 9. Download Attached Files

1. Open application with attached file
2. Click "Download" link
3. File downloads to your computer

---

## Project Structure

```
candidaturetracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ApplicationController.php
│   │   │   ├── InterviewController.php
│   │   │   └── AuthenticatedSessionController.php
│   │   ├── Requests/
│   │   │   ├── CreateApplicationRequest.php
│   │   │   ├── UpdateApplicationRequest.php
│   │   │   ├── CreateInterviewRequest.php
│   │   │   └── UpdateInterviewRequest.php
│   │   └── Middleware/
│   │       ├── Authenticate.php
│   │       └── VerifyCsrfToken.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Application.php
│   │   └── Interview.php
│   ├── Policies/
│   │   ├── ApplicationPolicy.php
│   │   └── InterviewPolicy.php
│   └── Traits/
│       └── SoftDeleteHelper.php
├── database/
│   ├── migrations/
│   │   ├── 2024_*.._create_users_table.php
│   │   ├── 2024_*.._create_applications_table.php
│   │   └── 2024_*.._create_interviews_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── UserSeeder.php
│   │   └── ApplicationSeeder.php
│   └── database.sqlite
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── guest.blade.php
│   │   ├── applications/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── show.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── archives.blade.php
│   │   ├── interviews/
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── partials.blade.php
│   │   └── auth/
│   │       ├── register.blade.php
│   │       ├── login.blade.php
│   │       └── forgot-password.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── routes/
│   ├── web.php
│   ├── auth.php
│   └── api.php
├── tests/
│   ├── Feature/
│   │   ├── AuthenticationTest.php
│   │   ├── ApplicationTest.php
│   │   ├── InterviewTest.php
│   │   └── DatabaseTest.php
│   └── Unit/
│       ├── ApplicationTest.php
│       └── InterviewTest.php
├── storage/
│   ├── app/  # Application files (attachments)
│   ├── logs/
│   └── framework/
├── .env.example
├── .gitignore
├── composer.json
├── package.json
├── phpunit.xml
├── tailwind.config.js
└── vite.config.js
```

---

## Architecture & Design

### Entity Relationship Diagram (ERD)

```
┌─────────────┐
│   User      │
├─────────────┤
│ id (PK)     │
│ name        │
│ email       │
│ password    │
│ timestamps  │
└──────┬──────┘
       │ 1:N
       │
       └─────────────────────┐
                             │
                    ┌────────▼──────────┐
                    │  Application      │
                    ├───────────────────┤
                    │ id (PK)           │
                    │ user_id (FK)      │
                    │ company_name      │
                    │ target_role       │
                    │ job_posting_url   │
                    │ status            │
                    │ priority          │
                    │ notes             │
                    │ application_date  │
                    │ file_path         │
                    │ deleted_at        │ ← Soft Delete
                    │ timestamps        │
                    └────────┬──────────┘
                             │ 1:N
                             │
                    ┌────────▼──────────┐
                    │  Interview        │
                    ├───────────────────┤
                    │ id (PK)           │
                    │ application_id(FK)│
                    │ type              │
                    │ scheduled_at      │
                    │ preparation_notes │
                    │ result            │
                    │ timestamps        │
                    └───────────────────┘
```

### Data Model

#### Users
- Unique email per user
- Hashed passwords (bcrypt)
- Timestamps: created_at, updated_at

#### Applications
- Belongs to User (1:N)
- Has many Interviews (1:N)
- Soft deletes for archiving
- Statuses: Pending, Shortlisted, Interview, Offer, Rejected (French)
- Priorities: Low, Medium, High (French)
- Optional file attachment via Storage

#### Interviews
- Belongs to Application (N:1)
- Types: Phone Screen, Technical Test, First, Second, Final Interview
- Results: Passed, Failed, Pending
- Scheduled date/time for calendar integration

---

## Key Technical Decisions

### 1. Authentication: Laravel Breeze
**Why:** Simple, secure, no-bloat authentication system
- Email/password authentication
- Password reset via email
- Session-based (suitable for monolith)
- Scaffolding provides ready-to-use UI

### 2. Authorization: Policies
**Why:** Secure, role-free access control at model level
- ApplicationPolicy checks user ownership
- InterviewPolicy checks through Application relationship
- Used in controllers + Blade templates for consistency
- Prevents privilege escalation vulnerabilities

### 3. Archiving: Soft Deletes
**Why:** Keep data for audits/history without clutter
- Applications table has `deleted_at` column
- SoftDeletes trait automatically filters archived
- Restore functionality via `restore()` method
- Interviews cascade-deleted with Application

### 4. File Storage: Laravel Storage
**Why:** Abstraction layer for multiple storage backends
- Local storage for development (storage/app/)
- Easy migration to S3/cloud without code changes
- Security: files stored outside public web root
- Auto-cleanup on Application deletion via Model events

### 5. Validation: Form Request Classes
**Why:** Clean controllers, reusable rules, centralized validation
- No $request->validate() in controllers
- Supports authorization checks
- Custom error messages
- Separate classes per action (Create/Update)

### 6. Query Optimization: Eager Loading
**Why:** Zero N+1 queries = fast page loads
- Applications index: `with('interviews')`
- Application show: `with(['interviews', 'user'])`
- Verified with Laravel Debugbar
- Always check query count in tests

### 7. CSRF Protection: @csrf Blade Directive
**Why:** Prevents cross-site request forgery attacks
- All POST/PUT/PATCH/DELETE forms include token
- VerifyCsrfToken middleware validates
- Automatic with Laravel Breeze forms

### 8. Templating: Blade with Tailwind CSS
**Why:** Native Laravel templating + modern styling
- Component-based structure
- @forelse for safe list rendering
- Responsive design with TailwindCSS
- Alpine.js for lightweight interactivity

### 9. Testing: Pest PHP
**Why:** Modern, expressive test syntax
- Better readability than PHPUnit
- Organized feature/unit tests
- Easy mocking and assertions
- Database transactions for test isolation

### 10. Localization: French Enums
**Why:** Support job search in French-speaking context
- Statuses displayed in French: "Entretien" not "Interview"
- Priorities: "Basse", "Moyenne", "Haute"
- Labels in forms and lists
- Can be extended to full i18n

---

## Troubleshooting

### Issue: "SQLSTATE[HY000] [2002] Connection refused"

**Cause:** Database server not running

**Solution:**
```bash
# Start MySQL/MariaDB
# macOS with Homebrew
brew services start mysql

# Linux
sudo systemctl start mysql

# Windows
net start MySQL80

# Or use XAMPP/MAMP to start from GUI
```

---

### Issue: "Class 'App\Models\Application' not found"

**Cause:** Models not generated or autoloading issue

**Solution:**
```bash
# Regenerate autoloader
composer dump-autoload

# Verify model exists
ls app/Models/
```

---

### Issue: "The APP_KEY environment variable is not set"

**Cause:** .env file missing or key not generated

**Solution:**
```bash
cp .env.example .env
php artisan key:generate
```

---

### Issue: "Route [applications.index] not defined"

**Cause:** Named route not defined in routes/web.php

**Solution:**
```bash
# Check routes
php artisan route:list | grep applications

# Ensure routes are named:
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
```

---

### Issue: "N+1 queries detected in Debugbar"

**Cause:** Missing eager loading in controller

**Solution:**
```php
// ❌ Bad (N+1)
$applications = Application::all();
foreach ($applications as $app) {
    echo $app->interviews->count();
}

// ✅ Good (Eager loading)
$applications = Application::with('interviews')->get();
foreach ($applications as $app) {
    echo $app->interviews->count();
}
```

---

### Issue: "View [applications.index] not found"

**Cause:** Blade template missing

**Solution:**
```bash
# Create missing view
touch resources/views/applications/index.blade.php

# Verify structure
ls resources/views/applications/
```

---

### Issue: "Failed to authenticate user in tests"

**Cause:** User not created or session not established

**Solution:**
```php
// ✅ Correct test setup
use Tests\TestCase;

class ApplicationTest extends TestCase {
    public function test_user_can_view_applications() {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->get(route('applications.index'));
        
        $response->assertStatus(200);
    }
}
```

---

### Issue: "Storage disk [local] does not have a configured path"

**Cause:** Storage path not configured in config/filesystems.php

**Solution:**
```bash
# Verify config exists
cat config/filesystems.php

# Create storage directory if missing
mkdir -p storage/app
chmod -R 775 storage/

# Clear configuration cache
php artisan config:clear
```

---

## Contributing

### Development Workflow

1. **Create feature branch**
   ```bash
   git checkout -b feature/add-calendar-sync
   ```

2. **Write tests first** (TDD)
   ```bash
   php artisan make:test ApplicationCalendarTest
   # Write failing test
   # Implement feature
   # Test passes
   ```

3. **Commit with clear messages**
   ```bash
   git commit -m "[FEATURE] Add calendar synchronization"
   git commit -m "[FIX] Prevent N+1 on interviews list"
   git commit -m "[TESTS] Add calendar sync integration tests"
   ```

4. **Push and create pull request**
   ```bash
   git push origin feature/add-calendar-sync
   ```

5. **Code review checklist**
   - [ ] Tests pass: `php artisan test`
   - [ ] No N+1 queries: verified in Debugbar
   - [ ] Authorization checks in place
   - [ ] CSRF tokens on forms
   - [ ] French labels used correctly
   - [ ] Documentation updated

---

## License

This project is licensed under the MIT License. See the LICENSE file for details.

---

## Support

For issues, questions, or suggestions:

1. Check existing GitHub Issues
2. Review Troubleshooting section above
3. Open new Issue with:
   - Steps to reproduce
   - Expected vs actual behavior
   - Environment details (PHP version, OS, etc.)

---

## Project Timeline

| Phase | Dates | Status |
|-------|-------|--------|
| Planning & Setup | 18/05 - 19/05 | In Progress |
| Core Development | 19/05 - 21/05 | Not Started |
| Testing & QA | 21/05 - 22/05 | Not Started |
| Final Review | 22/05 | Not Started |

**Deadline:** Friday 22/05/2026 at 16:30

---

## Acknowledgments

- Laravel documentation and community
- Pest PHP testing framework
- Laravel Breeze for authentication scaffolding
- TailwindCSS for styling

---

**Last Updated:** May 18, 2026  
**Maintainer:** Your Name  
**Version:** 1.0.0 (In Development)