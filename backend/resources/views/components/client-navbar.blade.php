<nav class="navbar navbar-expand-lg navbar-light bg-light">
    {{-- general settings: {{ $results['generalSettings'] }} --}}
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <span class="badge">
                <img src="./profile_picture.png" alt="Liviu Voica profile picture" class="navbar-profile">
            </span>
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
            <div>
                <p>Liviu Voica</p>
                <p>There's no place like 127.0.0.1</p>
                <div></div>
            </div>
            <div>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @foreach ($results['menuItems'] as $key => $item)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $item['path'] }}">
                                {{ __($item['title']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</nav>
