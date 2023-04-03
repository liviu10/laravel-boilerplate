@extends('layouts.admin')

@section('content')
    <div class="admin profile">
        @include('components.page-title', [
            'title' => __('profile.page_title')
        ])

        <div class="menu">
            <div class="row">
                <div class="card col-lg-8 col-md-8 col-sm-8">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="profile_alert">
                                <p class="my-0">{{ $message }}</p>
                                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update', $displayUserProfile['id']) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" value="{{ $displayUserProfile['id'] }}">

                            <!-- Contact details -->
                            <div>
                                <div class="row">
                                    <p class="lead">
                                        {{ __('profile.contact_details') }}
                                    </p>
                                </div>

                                <!-- Full name -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.full_name_label'),
                                        'id' => 'full_name',
                                        'type' => 'text',
                                        'value' => $displayUserProfile['full_name'],
                                        'autocomplete' => 'full_name',
                                        'disabled' => false
                                    ]
                                ])

                                <!-- First name -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.first_name_label'),
                                        'id' => 'first_name',
                                        'type' => 'text',
                                        'value' => $displayUserProfile['first_name'],
                                        'autocomplete' => 'first_name',
                                        'disabled' => false
                                    ]
                                ])

                                <!-- Last name -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.last_name_label'),
                                        'id' => 'last_name',
                                        'type' => 'text',
                                        'value' => $displayUserProfile['last_name'],
                                        'autocomplete' => 'last_name',
                                        'disabled' => false
                                    ]
                                ])

                                <!-- Profile picture -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.profile_picture_label'),
                                        'id' => 'profile_image',
                                        'type' => 'file',
                                        'value' => $displayUserProfile['profile_image'],
                                        'view_image_label' => __('profile.view_image_label'),
                                        'autocomplete' => 'profile_image',
                                        'disabled' => false
                                    ]
                                ])
                            </div>

                            <!-- Email & Nickname details -->
                            <div>
                                <div class="row">
                                    <p class="lead">
                                        {{ __('profile.email_details') }}
                                    </p>
                                </div>

                                <!-- Nickname -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.nickname_label'),
                                        'id' => 'nickname',
                                        'type' => 'text',
                                        'value' => $displayUserProfile['nickname'],
                                        'autocomplete' => 'nickname',
                                        'disabled' => false
                                    ]
                                ])

                                <!-- Email address -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.email_address_label'),
                                        'id' => 'email',
                                        'type' => 'email',
                                        'value' => $displayUserProfile['email'],
                                        'autocomplete' => 'email',
                                        'disabled' => true
                                    ]
                                ])
                            </div>

                            <!-- Password details -->
                            <div>
                                <div class="row">
                                    <p class="lead">
                                        {{ __('profile.password_details') }}
                                    </p>
                                </div>

                                <!-- Password -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.password_label'),
                                        'id' => 'password',
                                        'type' => 'password',
                                        'autocomplete' => 'new-password',
                                        'disabled' => false
                                    ]
                                ])

                                <!-- Password confirmation -->
                                @include('components.input', [
                                    'input' => [
                                        'label' => __('profile.password_confirmation_label'),
                                        'id' => 'password_confirmation',
                                        'type' => 'password',
                                        'autocomplete' => 'new-password',
                                        'disabled' => false
                                    ]
                                ])
                            </div>

                            <div class="card-actions">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('profile.update_button') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
