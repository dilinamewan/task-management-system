<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tasks text-white text-sm"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-900">Task Manager</h1>
            </div>
            <button id="closeSidebar" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-3">
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                    Dashboard
                </a>

                <!-- Tasks -->
                <a href="{{ route('tasks.index') }}" 
                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('tasks.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fas fa-clipboard-list w-5 h-5 mr-3 {{ request()->routeIs('tasks.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                    Tasks
                </a>

                @if(auth()->user()->isAdmin())
                    <!-- Users (Admin only) -->
                    <a href="{{ route('users.index') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-users w-5 h-5 mr-3 {{ request()->routeIs('users.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Users
                    </a>
                @endif
            </div>

            <!-- Secondary Navigation -->
            <div class="mt-8">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <i class="fas fa-user-cog w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Profile Settings
                    </a>
                </div>
            </div>
        </nav>

        <!-- User Profile -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-medium">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    @if(auth()->user()->isAdmin())
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            Admin
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between h-16 px-6">
                <div class="flex items-center space-x-4">
                    <button id="openSidebar" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    @if (isset($header))
                        <div class="flex items-center space-x-2">
                            {{ $header }}
                        </div>
                    @endif
                </div>

                <!-- Header Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <i class="fas fa-bell text-lg"></i>
                    </button>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-medium">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-cog w-4 h-4 mr-2"></i>
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-4 h-4 mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <div class="p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center animate-fade-in">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center animate-fade-in">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                        <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg animate-fade-in">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span class="font-medium">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<!-- Sidebar Overlay for Mobile -->
<div id="sidebarOverlay" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out lg:hidden"></div>

<!-- Scripts -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
    });
</script>
