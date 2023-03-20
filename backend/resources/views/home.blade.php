@extends('layouts.admin')

@section('content')
    <div class="admin home">
        <h1>
            {{ __('home.page_title') }}
        </h1>

        <div class="hero">
            <div class="card col-lg-8 col-md-8 col-sm-8">
                <div class="card-body">
                    <p class="lead">
                        {{ __('home.welcome', [ 'userName' => Auth::user()->full_name ]) }}
                    </p>
                    <p>
                        {{ __('home.logged_in_message', [ 'appName' => config('app.name') ]) }}
                    </p>
                    <p>
                        {{ __('home.app_short_description') }}
                        <br>
                        {!! __('home.app_description', [
                            'laravelUrl' => 'https://laravel.com/docs/7.x/authentication',
                            'laravelUrlName' => 'Laravel UI',
                            'bootstrapUrl' => 'https://getbootstrap.com/docs/5.2/getting-started/introduction/',
                            'bootstrapUrlName' => 'Bootstrap 5.2'
                        ]) !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="menu">
            @if (Auth::user()->user_role_type->id === 1)
            <div class="row">
                <div class="card col-lg-4 col-md-4 col-sm-4">
                    <div class="card-body">
                        <p class="lead">
                            {{ __('home.account_section.title') }}
                        </p>
                        <p>
                            {{ __('home.account_section.description') }}
                        </p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/profile') }}" class="btn btn-primary">
                            {{ __('home.account_section.button') }}
                        </a>
                    </div>
                </div>
                <div class="card col-lg-4 col-md-4 col-sm-4">
                    <div class="card-body">
                        <p class="lead">
                            {{ __('home.users_section.title') }}
                        </p>
                        <p>
                            {{ __('home.users_section.description') }}
                        </p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/users') }}" class="btn btn-primary">
                            {{ __('home.account_section.button') }}
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="card col-lg-8 col-md-8 col-sm-8 mx-auto">
                    <div class="card-body">
                        <p class="lead">
                            {{ __('home.account_section.title') }}
                        </p>
                        <p>
                            {{ __('home.account_section.description') }}
                        </p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/profile') }}" class="btn btn-primary">
                            {{ __('home.account_section.button') }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
