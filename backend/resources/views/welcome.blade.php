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
                    @include('components.generic.list', [
                        'listContent' => [
                            'git clone https://github.com/liviu10/laravel-boilerplate.git',
                            'cd laravel-boilerplate/backend/',
                            'composer install',
                            'npm install && npm run dev',
                            'duplicate .env.example and rename the file to .env and configure your database connection variables',
                            'php artisan key:generate',
                            'php artisan migrate',
                            'php artisan db:seed'
                        ]
                    ])
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
