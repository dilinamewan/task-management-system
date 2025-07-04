<nav class="navbar navbar-expand-lg navbar-dark bg-gradient shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container-fluid px-4">
        <!-- Brand -->
        <a class="navbar-brand fw-bold fs-4" href="{{ route('dashboard') }}">
            <i class="fas fa-tasks me-2 text-warning"></i>
            <span class="text-white">Task Manager</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Main Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 py-2 rounded-pill {{ request()->routeIs('dashboard') ? 'bg-white text-dark fw-semibold' : 'text-white-50 hover-effect' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 py-2 rounded-pill {{ request()->routeIs('tasks.*') ? 'bg-white text-dark fw-semibold' : 'text-white-50 hover-effect' }}" href="{{ route('tasks.index') }}">
                        <i class="fas fa-tasks me-2"></i>Tasks
                    </a>
                </li>
                @if(auth()->user()->isAdmin())
                    <li class="nav-item mx-1">
                        <a class="nav-link px-3 py-2 rounded-pill {{ request()->routeIs('users.*') ? 'bg-white text-dark fw-semibold' : 'text-white-50 hover-effect' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-users me-2"></i>Users
                        </a>
                    </li>
                @endif
            </ul>

            <!-- User Menu -->
            <ul class="navbar-nav">
                <!-- User Info -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white px-3 py-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar bg-white text-dark rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 14px; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="d-flex flex-column align-items-start">
                            <span class="fw-semibold mb-0" style="font-size: 14px;">{{ Auth::user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <small class="text-warning mb-0" style="font-size: 11px;">
                                    <i class="fas fa-crown me-1"></i>Administrator
                                </small>
                            @else
                                <small class="text-white-50 mb-0" style="font-size: 11px;">User</small>
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="min-width: 200px; margin-top: 10px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-cog me-2 text-primary"></i>Edit Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2 text-success"></i>Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .hover-effect:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        transform: translateY(-1px);
        transition: all 0.3s ease;
    }
    
    .navbar-nav .nav-link {
        transition: all 0.3s ease;
        border-radius: 25px;
    }
    
    .dropdown-menu {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        transition: all 0.2s ease;
    }
    
    .user-avatar {
        transition: all 0.3s ease;
    }
    
    .nav-link:hover .user-avatar {
        transform: scale(1.1);
    }
    
    .navbar-brand:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
</style>