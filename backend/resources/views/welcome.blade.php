@extends('layouts.guest')

@section('content')
    <div class="guest">
        <div class="hero">
            <div class="hero-header">
                Laravel Boilerplate
            </div>
            <div class="hero-body">
                <p class="lead mb-4">
                    This is a laravel web application starter kit.
                    <br>
                    <a href="https://laravel.com/docs/7.x/authentication">Laravel UI</a> with <a href="https://getbootstrap.com/docs/5.2/getting-started/introduction/">Bootstrap 5</a> was used as the main authentication system.
                </p>
                <p class="mb-2">
                    To install and run this application you can follow the instructions below:
                </p>
                <div class="mb-4 hero-body-instructions">
                    <ul class="list-group">
                        <li class="list-group-item">
                            git clone https://github.com/liviu10/laravel-boilerplate.git
                        </li>
                        <li class="list-group-item">
                            cd laravel-boilerplate/backend/
                        </li>
                        <li class="list-group-item">
                            composer install
                        </li>
                        <li class="list-group-item">
                            npm install && npm run dev
                        </li>
                        <li class="list-group-item">
                            duplicate .env.example and rename the file to .env and configure your database connection variables
                        </li>
                        <li class="list-group-item">
                            php artisan migrate
                        </li>
                        <li class="list-group-item">
                            php artisan db:seed
                        </li>
                    </ul>
                </div>
                @if (!Auth::user())
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
