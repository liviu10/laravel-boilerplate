<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ $adminNavigationBar['url'] }}">
            Navbar
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ $adminNavigationBar['url'] }}">
                        {{ $adminNavigationBar['title'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $adminNavigationBar['communication_url'] }}">
                        {{ $adminNavigationBar['communication_title'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $adminNavigationBar['management_url'] }}">
                        {{ $adminNavigationBar['management_title'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $adminNavigationBar['settings_url'] }}">
                        {{ $adminNavigationBar['settings_title'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $adminNavigationBar['view_website_url'] }}">
                        {{ $adminNavigationBar['view_website_title'] }}
                        <i class="fa-solid fa-up-right-from-square"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a
                        id="navbarDropdown"
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        v-pre
                    >
                        Welcome, {{ Auth::user()->full_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fa-solid fa-user"></i>
                                My account
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
