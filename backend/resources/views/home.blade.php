@extends('layouts.admin')

@section('content')
    <div class="admin home">
        <h1>
            {{ __('Dashboard') }}
        </h1>

        <div class="hero">
            <div class="card col-lg-8 col-md-8 col-sm-8">
                <div class="card-body">
                    <p class="lead">{{ __('Welcome') }}, {{ Auth::user()->full_name }}</p>
                    <p>
                        You are now logged in to {{ config('app.name') }}'s administration panel.
                    </p>
                    <p>
                        This is a laravel web application starter kit.
                        <br>
                        <a href="https://laravel.com/docs/7.x/authentication">Laravel UI</a> with <a href="https://getbootstrap.com/docs/5.2/getting-started/introduction/">Bootstrap 5</a> was used as the main authentication system.
                    </p>
                </div>
            </div>
        </div>

        <div class="menu">
            @if (Auth::user()->user_role_type->id === 1)
            <div class="row">
                <div class="card col-lg-4 col-md-4 col-sm-4">
                    <div class="card-body">
                        <p class="lead">My account</p>
                        <p>Modify your profile information (name, nickname, email address and password)</p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/profile') }}" class="btn btn-primary">View more</a>
                    </div>
                </div>
                <div class="card col-lg-4 col-md-4 col-sm-4">
                    <div class="card-body">
                        <p class="lead">Users & Role Types</p>
                        <p>Modify the name and assign users to different role types (webmaster, administrator, accountant, sales, client)</p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/users') }}" class="btn btn-primary">View more</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card col-lg-4 col-md-4 col-sm-4 mx-auto">
                    <div class="card-body">
                        <p class="lead">Settings</p>
                        <p>Modify the website settings</p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/settings') }}" class="btn btn-primary">View more</a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="card col-lg-8 col-md-8 col-sm-8 mx-auto">
                    <div class="card-body">
                        <p class="lead">My account</p>
                        <p>Modify your profile information (name, nickname, email address and password)</p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/profile') }}" class="btn btn-primary">View more</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
