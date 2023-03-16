<nav class="navbar navbar-expand-lg bg-light" style="margin-bottom: 32px;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/home') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/home') }}">
                        {{ __('admin.navbar.home') }}
                    </a>
                </li>
            </ul>
            <div>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('admin.navbar.welcome') }}, {{ Auth::user()->full_name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('/profile') }}">
                                    {{ __('admin.navbar.profile') }}
                                </a>
                            </li>
                            @if (Auth::user()->user_role_type_id === 1)
                            <li>
                                <a class="dropdown-item" href="{{ url('/users') }}">
                                    {{ __('admin.navbar.users') }}
                                </a>
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('settings') }}">
                                    {{ __('admin.navbar.settings') }}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('admin.navbar.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
