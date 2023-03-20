<div class="admin">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar top-bar"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                            {{ __('admin.navbar.home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('welcome') }}" target="_blank">
                            {{ __('admin.navbar.view_website') }}
                        </a>
                    </li>
                </ul>
                <div>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('admin.navbar.welcome', [ 'userName' => Auth::user()->full_name ]) }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/profile') }}">
                                        <i class="fa-solid fa-user"></i>
                                        <span>{{ __('admin.navbar.profile') }}</span>
                                    </a>
                                </li>
                                @if (Auth::user()->user_role_type_id === 1)
                                <li>
                                    <a class="dropdown-item" href="{{ url('/users') }}">
                                        <i class="fa-solid fa-users"></i>
                                        <span>{{ __('admin.navbar.users') }}</span>
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('welcome') }}" target="_blank">
                                        <i class="fa-solid fa-link"></i>
                                        <span>{{ __('admin.navbar.view_website') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-sharp fa-solid fa-arrow-right-from-bracket"></i>
                                        <span>{{ __('admin.navbar.logout') }}</span>
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
</div>
