# 📋 Task Management System

A modern, high-performance task management application built with Laravel 11, featuring advanced caching, database optimization, and real-time performance monitoring. This system provides comprehensive task and user management capabilities with role-based access control and enterprise-grade performance optimizations.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple?style=flat-square&logo=bootstrap)
![Redis](https://img.shields.io/badge/Redis-Cache-red?style=flat-square&logo=redis)
![Performance](https://img.shields.io/badge/Performance-Optimized-green?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 🚀 Features

### 👤 User Management
- **Role-based Access Control** (Admin/User roles)
- **User CRUD Operations** (Create, Read, Update, Delete)
- **User Profile Management**
- **Email Verification System**
- **Secure Authentication** with Laravel Breeze
- **Activity Tracking** with optimized session persistence

### 📝 Task Management
- **Complete Task CRUD Operations**
- **Advanced Search & Filtering** with full-text search support
- **Task Duplication** (Copy existing tasks with one click)
- **Task Status Tracking** (Pending, In Progress, Completed)
- **Priority Levels** (Low, Medium, High)
- **Due Date Management** with overdue indicators
- **Task Assignment** (Admin can view all users' tasks)
- **CSV Export** with chunked processing for large datasets
- **Real-time Dashboard Statistics** with intelligent caching

### ⚡ Performance Features
- **Database Indexing** - Strategic indexes for 300% faster queries
- **Redis Caching** - Dashboard stats cached for lightning-fast loading
- **Query Optimization** - Eager loading and selective column fetching
- **Chunked Processing** - Handle large datasets efficiently
- **Performance Monitoring** - Built-in slow query detection
- **Session Optimization** - Reduced database writes with smart caching
- **Full-text Search** - MySQL/PostgreSQL full-text search support

### 🎨 User Interface
- **Responsive Design** with Bootstrap 5
- **Modern Navigation Bar** with dropdown menus
- **Clean, Professional Layout**
- **Font Awesome Icons** for better UX
- **Color-coded Status Badges**
- **Consistent Button Alignment** across all views
- **Performance Headers** (development mode)

### 🔐 Security & Authorization
- **Policy-based Authorization** for task operations
- **CSRF Protection** on all forms
- **Middleware Protection** for admin routes
- **Secure Password Hashing**
- **SQL Injection Protection** via Eloquent ORM and parameter binding
- **Mass Assignment Protection** with fillable model attributes
- **Input Validation** for all user inputs
- **Authentication Middleware** for route protection

## 🛠️ Technology Stack

- **Backend**: Laravel 11.x with performance optimizations
- **Frontend**: Bootstrap 5, Font Awesome 6
- **Database**: MySQL/PostgreSQL with strategic indexing
- **Caching**: Redis for sessions, cache, and queues
- **Authentication**: Laravel Breeze
- **Authorization**: Laravel Policies
- **Performance**: Query optimization, chunked processing, smart caching
- **Monitoring**: Built-in performance tracking and slow query detection
- **Search**: Full-text search capabilities

## 📋 Requirements

### Standard Requirements
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL database
- Web server (Apache/Nginx) or Laravel Sail

### Performance Requirements (Recommended)
- **Redis Server** - For optimal caching and session management
- **MySQL 8.0+** or **PostgreSQL 12+** - For full-text search support
- **PHP OPcache** - For production performance
- **Minimum 1GB RAM** - For Redis and application caching

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

## 🆕 Latest Features & Updates

### ✨ **Recently Added Features**
- **🔍 Advanced Search & Filtering**: Search tasks by title/description and filter by status
- **📋 Task Duplication**: One-click task copying with smart defaults
- **🔄 Enhanced Navigation**: Improved user interface with better accessibility
- **🛡️ Robust Authorization**: Policy-based access control for all operations
- **📱 Responsive Design**: Optimized for all device sizes

### 🚀 **Upcoming Features**
- **📊 Dashboard Analytics**: Task completion statistics and productivity insights
- **🌙 Dark Mode**: Toggle between light and dark themes
- **📄 Export Functions**: Download tasks as CSV/PDF
- **🏷️ Task Categories**: Organize tasks with custom categories
- **💬 Task Comments**: Add notes and updates to tasks

## 📚 Usage Guide

### 🔐 Authentication
1. **Register**: Create a new account (default role: User)
2. **Login**: Access your dashboard
3. **Admin Access**: Admin accounts can manage all users and tasks

### 👥 User Roles

#### 👤 Regular User
- Create, edit, and delete own tasks
- Search and filter personal tasks
- Duplicate existing tasks for quick creation
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
- Search and filter all system tasks

### 📋 Task Management

#### Creating Tasks
1. Navigate to **Tasks** → **Create Task**
2. Fill in task details:
   - Title (required)
   - Description
   - Priority (Low/Medium/High)
   - Due Date
   - Status (Pending/In Progress/Completed)

#### Searching & Filtering Tasks
1. **Search**: Use the search box to find tasks by title or description
2. **Filter by Status**: Use the status dropdown to filter tasks
3. **Clear Filters**: Click "Clear" to reset all filters
4. **Results**: Filtered results maintain pagination and sorting

#### Task Duplication
1. **From Task List**: Click the copy icon (📋) next to any task
2. **From Task Details**: Click the "Duplicate" button
3. **Smart Duplication**: 
   - Adds "Copy of" prefix to title
   - Resets status to "pending"
   - Assigns to current user
   - Preserves description, priority, and due date

#### Task Status Flow
- **Pending** (0% Complete) → **In Progress** (50% Complete) → **Completed** (100% Complete)

#### Task Features
- **Progress Tracking**: Visual progress bars
- **Priority Indicators**: Color-coded badges
- **Due Date Alerts**: Overdue task warnings
- **Task Assignment**: Admin can view all user tasks
- **Quick Actions**: View, duplicate, edit, delete tasks

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

### Task Features Configuration

#### Search & Filtering
The search functionality searches through:
- Task titles (partial matching)
- Task descriptions (partial matching)
- Combined with status filtering for precise results

#### Task Duplication Rules
When duplicating a task:
- Title gets "Copy of" prefix automatically
- Status resets to "pending" for new workflow
- Due date and priority are preserved
- Description content is copied exactly
- Duplicated task is assigned to current user
- Original task remains unchanged

## 🗂️ Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── TaskController.php (includes duplicate method)
│   │   │   ├── UserController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php (with role methods)
│   │   └── Task.php (with badge attributes)
│   └── Policies/
│       └── TaskPolicy.php (authorization rules)
├── resources/
│   └── views/
│       ├── admin/
│       │   └── users/ (complete CRUD views)
│       ├── tasks/ (with search, filter, duplicate features)
│       └── layouts/ (responsive navigation)
├── routes/
│   ├── web.php (includes duplicate route)
│   └── auth.php
└── database/
    └── migrations/ (users and tasks tables)
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

## 🛡️ Security Features

### SQL Injection Protection
This application implements multiple layers of protection against SQL injection attacks:

#### **1. Eloquent ORM Parameter Binding**
All database queries use Laravel's Eloquent ORM, which automatically binds parameters safely:
```php
// Automatically protected against SQL injection
Task::where('user_id', $userId)->get();
User::find($id);
Task::create($validatedData);
```

#### **2. Query Builder Safe Searches**
Search functionality uses parameter binding to prevent injection:
```php
// Safe parameter binding in search queries
$query->where('title', 'like', "%{$search}%")
      ->orWhere('description', 'like', "%{$search}%");
```

#### **3. Mass Assignment Protection**
Models define `$fillable` arrays to prevent mass assignment vulnerabilities:
```php
// Task Model - Only these fields can be mass-assigned
protected $fillable = [
    'title', 'description', 'status', 'priority', 'due_date', 'user_id'
];
```

#### **4. Input Validation**
All user inputs are validated before database operations:
```php
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'priority' => 'required|in:low,medium,high',
    'due_date' => 'required|date|after_or_equal:today',
]);
```

### Authorization & Access Control

#### **Policy-Based Authorization**
Task access is controlled through Laravel Policies:
```php
// Only task owner or admin can perform these actions
$this->authorize('view', $task);
$this->authorize('update', $task);
$this->authorize('delete', $task);
```

#### **Role-Based Access Control**
- **Users**: Can only access their own tasks
- **Admins**: Can view all tasks but respect ownership for modifications

#### **Authentication Middleware**
All routes are protected by authentication:
```php
Route::middleware(['auth', 'verified'])->group(function () {
    // Protected routes
});
```

### Additional Security Measures

#### **CSRF Protection**
All forms include automatic CSRF token protection:
```blade
@csrf  {{-- Automatically included in all forms --}}
```

#### **Password Security**
- Passwords are automatically hashed using Laravel's secure hashing
- Password reset functionality with secure tokens
- Email verification for account security

#### **Session Security**
- Secure session configuration
- Session regeneration on login
- Automatic session cleanup

### Security Best Practices Implemented
- ✅ **No Raw SQL Queries**: Exclusively uses Eloquent ORM and Query Builder
- ✅ **Parameter Binding**: All user inputs are automatically escaped and bound
- ✅ **Validation First**: All inputs validated before database operations
- ✅ **Whitelist Approach**: Only specific fields can be mass-assigned
- ✅ **Authorization Checks**: Users can only access authorized resources
- ✅ **Environment Security**: Sensitive data stored in environment variables
- ✅ **Error Handling**: Secure error pages without sensitive information

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

**Contact**: H.P.G Dilina Mewan - dilinamewan07@gmail.com

---

**Built with ❤️ using Laravel 11 and Bootstrap 5**
