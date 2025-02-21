<!-- Sidebar Navigation -->
<div x-data="{
    open: localStorage.getItem('sidebarOpen') === 'true',
    init() {
        if (localStorage.getItem('sidebarOpen') === null) {
            this.open = false;
            localStorage.setItem('sidebarOpen', 'false');
        }
        this.$watch('open', value => {
            localStorage.setItem('sidebarOpen', value);
        });
    }
}" :class="{ 'open': open }" class="sidebar">
    <!-- Previous sidebar code remains unchanged until the top navigation bar -->
    <div class="menu-btn" :class="{ 'open': open }">
        <i class='bx bx-menu' @click="open = !open"></i>
    </div>

    <div class="logo-details">
        <a href="{{ Auth::user()->role === 'admin' ? route('dashboard') : route('user.dashboard') }}" class="logo-link">
            <img src="{{ asset('img/LGUlogo.png') }}" alt="Application Logo">
            <span class="logo_name" x-cloak x-show="open"
                  x-transition:enter="transition-opacity ease-out duration-300"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Equipment Transfer System</span>
        </a>
    </div>

    <ul class="nav-list">
        @auth
            <li>
                <a href="{{ Auth::user()->role === 'admin' ? route('dashboard') : route('user.dashboard') }}"
                   @click="$nextTick(() => { localStorage.setItem('sidebarOpen', open) })"
                   class="{{ request()->routeIs('dashboard') || request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name" x-cloak x-show="open"
                          x-transition:enter="transition-opacity ease-out duration-300"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100">Dashboard</span>
                </a>
                <span class="tooltip" x-show="!open">Dashboard</span>
            </li>

            @if (Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('user.management') }}"
                       @click="$nextTick(() => { localStorage.setItem('sidebarOpen', open) })"
                       class="{{ request()->routeIs('user.management') ? 'active' : '' }}">
                        <i class='bx bx-user'></i>
                        <span class="links_name" x-cloak x-show="open"
                              x-transition:enter="transition-opacity ease-out duration-300"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100">User Management</span>
                    </a>
                    <span class="tooltip" x-show="!open">User Management</span>
                </li>
            @endif

            <li>
                <a href="{{ route('transfer') }}"
                   @click="$nextTick(() => { localStorage.setItem('sidebarOpen', open) })"
                   class="{{ request()->routeIs('transfer') ? 'active' : '' }}">
                    <i class='bx bx-transfer'></i>
                    <span class="links_name" x-cloak x-show="open"
                          x-transition:enter="transition-opacity ease-out duration-300"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100">Transfer Item</span>
                </a>
                <span class="tooltip" x-show="!open">Transfer Item</span>
            </li>
            <li>
                <a href="{{ route('transferred') }}"
                   @click="$nextTick(() => { localStorage.setItem('sidebarOpen', open) })"
                   class="{{ request()->routeIs('transferred') ? 'active' : '' }}">
                    <i class='bx bx-check-square'></i>
                    <span class="links_name" x-cloak x-show="open"
                          x-transition:enter="transition-opacity ease-out duration-300"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100">Transferred Item</span>
                </a>
                <span class="tooltip" x-show="!open">Transferred Item</span>
            </li>
            <li>
                <a href="{{ route('activity.history') }}"
                   @click="$nextTick(() => { localStorage.setItem('sidebarOpen', open) })"
                   class="{{ request()->routeIs('activity.history') ? 'active' : '' }}">
                    <i class='bx bx-history'></i>
                    <span class="links_name" x-cloak x-show="open"
                          x-transition:enter="transition-opacity ease-out duration-300"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100">Activity History</span>
                </a>
                <span class="tooltip" x-show="!open">Activity History</span>
            </li>
        @endauth
    </ul>

    <div class="profile" :class="{ 'open': open }">
        <div class="profile-details">
            <div class="name_job">
                <div class="name" x-cloak x-show="open"
                     x-transition:enter="transition-opacity ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">{{ Auth::user()->name }}</div>
                <div class="job" x-cloak x-show="open"
                     x-transition:enter="transition-opacity ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">{{ Auth::user()->role }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();">
                <i class='bx bx-log-out' id="log_out"></i>
            </a>
        </form>
    </div>

    <!-- Top Navigation Bar -->
    <nav class="top-navbar" :class="{ 'sidebar-open': open }">
        <div class="navbar-content">
            <div class="left-section">
                <h2 class="page-title">
                    @php
                        $routeName = Route::currentRouteName();
                        $transferId = request()->route('id');
                    @endphp

                    @if(request()->routeIs('dashboard') || request()->routeIs('user.dashboard'))
                        Dashboard
                    @elseif(request()->routeIs('user.management'))
                        User Management
                    @elseif(request()->routeIs('additem'))
                        Add Item
                    @elseif(request()->routeIs('transfer'))
                        Transfer Management
                    @elseif(request()->routeIs('transferred'))
                        Transferred Items
                    @elseif(request()->routeIs('activity.history'))
                        Activity Log
                    @elseif(Str::contains(request()->path(), 'edit') && Str::contains(request()->path(), 'transferred'))
                        Edit Transferred Item
                    @elseif(Str::contains(request()->path(), 'show') && Str::contains(request()->path(), 'transferred'))
                        Item Details of Transferred Item
                    @elseif(Str::contains(request()->path(), 'edit'))
                        Edit Item
                    @elseif(Str::contains(request()->path(), 'show'))
                        Item Details
                    @else
                        {{ ucfirst(request()->segment(1)) }}
                    @endif
                </h2>
            </div>

            <div class="right-section">
                <div x-data="{ show: false }"
                     x-init="() => {
                         show = false;
                         window.addEventListener('popstate', () => show = false);
                         window.addEventListener('beforeunload', () => show = false);
                     }"
                     class="user-menu">
                    <button @click="show = !show"
                            class="user-menu-btn"
                            type="button">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <i class='bx bx-chevron-down' :class="{ 'transform rotate-180': show }"></i>
                    </button>
                    <div x-show="show"
                         x-cloak
                         @click.away="show = false"
                         @keydown.escape.window="show = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="user-dropdown">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-red-600">
                                <i class='bx bx-log-out'></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<style>
    [x-cloak] { display: none !important; }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 78px;
        background: #11101d;
        padding: 6px 14px;
        z-index: 99;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .sidebar.open {
        width: 250px;
    }

    .menu-btn {
        position: absolute;
        top: 6px;
        left: 50%;
        transform: translateX(-50%);
        padding: 6px;
        display: flex;
        justify-content: center;
        width: 50px;
        transition: all 0.3s ease;
        z-index: 100;
    }

    .menu-btn.open {
        left: calc(100% - 30px);
        transform: translateX(-50%);
    }

    .menu-btn i {
        color: #fff;
        font-size: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sidebar.open .menu-btn i {
        transform: rotate(180deg);
    }

    .logo-details {
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        margin-top: 40px;
    }

    .logo-link {
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        width: 50px;
        margin: 0 auto;
    }

    .sidebar.open .logo-link {
        width: 100%;
        margin: 0;
    }

    .logo-details img {
        height: 40px;
        width: 40px;
        object-fit: contain;
    }

    .logo-details .logo_name {
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        margin-left: 10px;
    }

    .sidebar .nav-list {
        margin-top: 20px;
        flex-grow: 1;
        padding: 0;
        margin-bottom: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .sidebar li {
        position: relative;
        margin: 8px 0;
        list-style: none;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .sidebar li .tooltip {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 122px;
        z-index: 3;
        background: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 400;
        opacity: 0;
        white-space: nowrap;
        pointer-events: none;
        transition: 0s;
    }

    .sidebar li:hover .tooltip {
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
        top: 50%;
        transform: translateY(-50%);
    }

    .sidebar.open li .tooltip {
        display: none;
    }

    .sidebar li a {
        display: flex;
        height: 100%;
        width: 50px;
        border-radius: 12px;
        align-items: center;
        text-decoration: none;
        background: #11101d;
        position: relative;
        transition: all 0.3s ease;
        padding: 12px;
        justify-content: center;
    }

    .sidebar.open li a {
        width: 100%;
        justify-content: flex-start;
    }

    .sidebar li a:hover,
    .sidebar li a.active {
        background: #fff;
    }

    .sidebar li a i {
        height: 35px;
        min-width: 35px;
        border-radius: 12px;
        line-height: 35px;
        text-align: center;
        color: #fff;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .sidebar li a:hover i,
    .sidebar li a.active i {
        color: #11101d;
    }

    .sidebar li a .links_name {
        color: #fff;
        font-size: 15px;
        font-weight: 400;
        white-space: nowrap;
        pointer-events: none;
        transition: 0.3s;
        margin-left: 10px;
        opacity: 0;
        display: none;
    }

    .sidebar.open li a .links_name {
        opacity: 1;
        display: block;
    }

    .sidebar li a:hover .links_name,
    .sidebar li a.active .links_name {
        color: #11101d;
    }

    .profile {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 78px;
        background: #1d1b31;
        padding: 10px 14px;
        transition: all 0.3s ease;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar.open .profile {
        width: 250px;
    }

    .profile-details {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-grow: 1;
    }

    .profile .name,
    .profile .job {
        font-size: 15px;
        font-weight: 400;
        color: #fff;
        white-space: nowrap;
        text-align: center;
    }

    .profile .job {
        font-size: 12px;
    }

    .logout-form {
        display: flex;
        justify-content: center;
        width: 50px;
    }

    .profile #log_out {
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        height: 35px;
        min-width: 35px;
        border-radius: 12px;
        line-height: 35px;
        text-align: center;
    }

    .home-section {
        position: relative;
        background: #E4E9F7;
        min-height: 100vh;
        top: 0;
        left: 78px;
        width: calc(100% - 78px);
        transition: all 0.3s ease;
        z-index: 2;
        margin-top: 64px;
    }

    .sidebar.open ~ .home-section {
        left: 250px;
        width: calc(100% - 250px);
    }

    .top-navbar {
        position: fixed;
        top: 0;
        right: 0;
        left: 78px;
        height: 64px;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        z-index: 98;
    }

    .top-navbar.sidebar-open {
        left: 250px;
    }

    .navbar-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
        padding: 0 24px;
    }

    .left-section .page-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .right-section {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .user-menu {
        position: relative;
    }

    .user-menu-btn {
        background: none;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .user-menu-btn:hover {
        background-color: #f3f4f6;
    }

    .user-menu-btn i {
        transition: transform 0.2s ease;
    }

    .user-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        width: 200px;
        z-index: 1000;
        border: 1px solid #e5e7eb;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        width: 100%;
        border: none;
        background: none;
        cursor: pointer;
        text-align: left;
        transition: background-color 0.2s;
        color: #1a1a1a;
        text-decoration: none;
    }

    .dropdown-item.text-red-600 {
        color: #dc2626;
    }

    .dropdown-item.text-red-600:hover {
        background-color: #fef2f2;
    }

    .user-name {
        font-weight: 500;
        color: #1a1a1a;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 78px;
        }

        .sidebar.open {
            width: 250px;
        }

        .home-section {
            left: 78px;
            width: calc(100% - 78px);
        }

        .sidebar.open ~ .home-section {
            left: 250px;
            width: calc(100% - 250px);
        }
    }
</style>

<!-- Add Boxicons CSS -->
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
