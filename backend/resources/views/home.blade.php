@extends('layouts.admin')

@section('content')
    <div class="admin home">
        @include('components.generic.page-title', [
            'title' => __('admin.home.page_title')
        ])

        <div class="hero">
            <div class="card col-lg-8 col-md-8 col-sm-8">
                <div class="card-body">
                    <p class="lead">
                        {{ __('admin.general.welcome_message', [ 'userName' => Auth::user()->full_name ]) }}
                    </p>
                    <p>
                        {{ __('admin.home.logged_in_message', [ 'appName' => config('app.name') ]) }}
                    </p>
                    <p>
                        {{ __('admin.home.app_short_description') }}
                        <br>
                        {!! __('admin.home.app_description', [
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
                            {{ __('admin.home.account_section.title') }}
                        </p>
                        <p>
                            {{ __('admin.home.account_section.description') }}
                        </p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('admin/profile') }}" class="btn btn-primary">
                            {{ __('admin.general.view_more_button_label') }}
                        </a>
                    </div>
                </div>
                <div class="card col-lg-4 col-md-4 col-sm-4">
                    <div class="card-body">
                        <p class="lead">
                            {{ __('admin.home.users_section.title') }}
                        </p>
                        <p>
                            {{ __('admin.home.users_section.description') }}
                        </p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('admin/users') }}" class="btn btn-primary">
                            {{ __('admin.general.view_more_button_label') }}
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="card col-lg-8 col-md-8 col-sm-8 mx-auto">
                    <div class="card-body">
                        <p class="lead">
                            {{ __('admin.home.account_section.title') }}
                        </p>
                        <p>
                            {{ __('admin.home.account_section.description') }}
                        </p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ url('/admin/profile') }}" class="btn btn-primary">
                            {{ __('admin.general.view_more_button_label') }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
