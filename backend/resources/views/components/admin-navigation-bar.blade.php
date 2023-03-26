<div class="admin">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ $adminNavigationBar['applicationName'] }}
            </a>
            <button
                class="navbar-toggler collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="icon-bar top-bar"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                            {{ $adminNavigationBar['homePage'] }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $adminNavigationBar['sections'] }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    {{ $adminNavigationBar['firstPage'] }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    {{ $adminNavigationBar['secondPage'] }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    {{ $adminNavigationBar['thirdPage'] }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('welcome') }}" target="_blank">
                            {{ $adminNavigationBar['viewWebsite'] }}
                        </a>
                    </li>
                </ul>
                <div>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi fi-{{ Config::get('languages')[App::getLocale()]['flag-icon'] }}"></span>
                                {{ Config::get('languages')[App::getLocale()]['display'] }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @foreach (Config::get('languages') as $lang => $language)
                                @if ($lang != App::getLocale())
                                    <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">
                                        <span class="fi fi-{{ $language['flag-icon'] }}" style="width: 1.33333333em;"></span>
                                        {{ $language['display'] }}
                                    </a>
                                @endif
                            @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $adminNavigationBar['welcome'] }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/profile') }}">
                                        <i class="fa-solid fa-user"></i>
                                        <span>{{ $adminNavigationBar['profile'] }}</span>
                                    </a>
                                </li>
                                @if (Auth::user()->user_role_type_id === 1)
                                <li>
                                    <a class="dropdown-item" href="{{ url('/users') }}">
                                        <i class="fa-solid fa-users"></i>
                                        <span>{{ $adminNavigationBar['users'] }}</span>
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('welcome') }}" target="_blank">
                                        <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
                                        <span>{{ $adminNavigationBar['viewWebsite'] }}</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-sharp fa-solid fa-arrow-right-from-bracket"></i>
                                        <span>{{ $adminNavigationBar['logout'] }}</span>
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
