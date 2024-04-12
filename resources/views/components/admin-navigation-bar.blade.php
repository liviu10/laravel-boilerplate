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
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {{ $adminNavigationBar['communication']['title'] }}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($adminNavigationBar['communication']['children'] as $value)
                            @foreach($value as $item)
                                <li>
                                    <a class="dropdown-item" href="{{ $item['url'] }}">
                                        {{ $item['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {{ $adminNavigationBar['management']['title'] }}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($adminNavigationBar['management']['children'] as $value)
                            @foreach($value as $item)
                                <li>
                                    <a class="dropdown-item" href="{{ $item['url'] }}">
                                        {{ $item['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {{ $adminNavigationBar['settings']['title'] }}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($adminNavigationBar['settings']['children'] as $value)
                            @foreach($value as $item)
                                <li>
                                    <a class="dropdown-item" href="{{ $item['url'] }}">
                                        {{ $item['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        View website
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
                        {{ Auth::user()->full_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                Action
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                Another action
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
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
