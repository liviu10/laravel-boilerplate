@extends('layouts.guest')

@section('content')
    <div class="row justify-content-center">
        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-5 fw-bold">Laravel Boilerplate</h1>
            <div class="mx-auto">
                <p class="lead mb-4">
                    This is a laravel web application starter kit.
                    <br>
                    <a href="https://laravel.com/docs/7.x/authentication">Laravel UI</a> with <a href="https://getbootstrap.com/docs/5.0/getting-started/introduction/">Bootstrap 5</a> is used as the main authentication system.
                </p>
                <p class="mb-0">
                    To install and run this application you can follow the instructions below:
                </p>
                <p class="mb-0 d-flex align-center items-center">
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
                </p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">Register</a>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 gap-3">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
