# 📋 Task Management System

A modern, feature-rich task management application built with Laravel 11, Bootstrap 5, and Font Awesome. This system provides comprehensive task and user management capabilities with role-based access control.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple?style=flat-square&logo=bootstrap)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 🚀 Features

### 👤 User Management
- **Role-based Access Control** (Admin/User roles)
- **User CRUD Operations** (Create, Read, Update, Delete)
- **User Profile Management**
- **Email Verification System**
- **Secure Authentication** with Laravel Breeze

### 📝 Task Management
- **Complete Task CRUD Operations**
- **Task Search & Filtering** (Search by title/description, filter by status)
- **Task Duplication** (Copy existing tasks with one click)
- **Task Status Tracking** (Pending, In Progress, Completed)
- **Priority Levels** (Low, Medium, High)
- **Due Date Management** with overdue indicators
- **Task Progress Visualization** (0%, 50%, 100%)
- **Task Assignment** (Admin can view all users' tasks)
- **Task Sorting** (Sort by creation date, status, priority)

### 🎨 User Interface
- **Responsive Design** with Bootstrap 5
- **Modern Navigation Bar** with dropdown menus
- **Clean, Professional Layout**
- **Font Awesome Icons** for better UX
- **Color-coded Status Badges**
- **Progress Bars** and visual indicators

### 🔐 Security & Authorization
- **Policy-based Authorization** for task operations
- **CSRF Protection** on all forms
- **Middleware Protection** for admin routes
- **Secure Password Hashing**

## 🛠️ Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Bootstrap 5, Font Awesome 6
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Breeze
- **Authorization**: Laravel Policies
- **Styling**: Bootstrap CSS Framework
- **Icons**: Font Awesome

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL or SQLite database
- Web server (Apache/Nginx) or Laravel Sail

## ⚡ Quick Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd task-management-system
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed
```

### 6. Build Assets
```bash
# Compile assets
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 📚 Usage Guide

### 🔐 Authentication
1. **Register**: Create a new account (default role: User)
2. **Login**: Access your dashboard
3. **Admin Access**: Admin accounts can manage all users and tasks

### 👥 User Roles

#### 👤 Regular User
- Create, edit, and delete own tasks
- View personal task dashboard
- Manage personal profile
- Track task progress

#### 🛡️ Admin User
- All user permissions
- Access to Users management section
- View and manage all users
- Create new admin/user accounts
- Delete users and their tasks
- System-wide task overview

### 📋 Task Management

#### Creating Tasks
1. Navigate to **Tasks** → **Create Task**
2. Fill in task details:
   - Title (required)
   - Description
   - Priority (Low/Medium/High)
   - Due Date
   - Status (Pending/In Progress/Completed)

#### Task Status Flow
- **Pending** (0% Complete) → **In Progress** (50% Complete) → **Completed** (100% Complete)

#### Task Features
- **Progress Tracking**: Visual progress bars
- **Priority Indicators**: Color-coded badges
- **Due Date Alerts**: Overdue task warnings
- **Task Assignment**: Admin can view all user tasks

### 🎯 Navigation

#### Main Navigation
- **Dashboard**: Overview of your tasks
- **Tasks**: Task management interface
- **Users**: User management (Admin only)

#### User Menu Dropdown
- **Profile**: Edit personal information
- **Dashboard**: Quick access to dashboard
- **Logout**: Secure session termination

## 🔧 Advanced Configuration

### Admin User Creation
To create an admin user manually:

1. **Via Database**:
```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

2. **Via Tinker**:
```bash
php artisan tinker
User::where('email', 'your-email@example.com')->update(['role' => 'admin']);
```

### Middleware Configuration
The system uses custom middleware for admin protection:
- `AdminMiddleware`: Restricts access to admin-only routes
- Registered in `bootstrap/app.php`

### Task Policies
Authorization is handled through Laravel Policies:
- Users can only manage their own tasks
- Admins can view all tasks but respect user ownership for modifications

## 🗂️ Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── TaskController.php
│   │   │   ├── UserController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   └── Task.php
│   └── Policies/
│       └── TaskPolicy.php
├── resources/
│   └── views/
│       ├── admin/
│       │   └── users/
│       ├── tasks/
│       └── layouts/
├── routes/
│   ├── web.php
│   └── auth.php
└── database/
    └── migrations/
```

## 🎨 Customization

### Styling
- Bootstrap classes can be customized in `resources/css/app.css`
- Navigation styling in `resources/views/layouts/navigation.blade.php`

### Adding New Task Status
1. Update migration: `database/migrations/*_create_tasks_table.php`
2. Update Task model: `app/Models/Task.php`
3. Update progress calculation in task views

### Custom User Roles
1. Modify User model: `app/Models/User.php`
2. Update middleware: `app/Http/Middleware/AdminMiddleware.php`
3. Adjust authorization policies as needed

## 🐛 Troubleshooting

### Common Issues

1. **"Target class [admin] does not exist"**
   - Run: `php artisan config:clear`
   - Ensure middleware is registered in `bootstrap/app.php`

2. **Bootstrap/CSS not loading**
   - Run: `npm run build`
   - Check asset compilation

3. **Permission denied errors**
   - Check file permissions
   - Ensure storage and cache directories are writable

4. **Database connection issues**
   - Verify `.env` database configuration
   - Ensure database server is running

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support, please create an issue in the repository or contact the development team.

---

**Built with ❤️ using Laravel 11 and Bootstrap 5**
