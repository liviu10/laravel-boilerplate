@extends('layouts.admin')

@section('content')
    <div class="admin profile">
        <h1>
            {{ __('Profile') }}
        </h1>

        <div class="menu">
            <div class="row">
                <div class="card col-lg-8 col-md-8 col-sm-8">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertTest">
                                <p class="my-0">{{ $message }}</p>
                                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update', $displayUserProfile->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" value="{{ $displayUserProfile->id }}">

                            <!-- Contact details -->
                            <div>
                                <div class="row">
                                    <p class="lead">
                                        {{ __('Contact details') }}
                                    </p>
                                </div>

                                <!-- Full name -->
                                <div class="row mb-3">
                                    <label for="full_name" class="form-label">{{ __('Full Name') }}</label>

                                    <div class="">
                                        <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $displayUserProfile->full_name }}" required autocomplete="name" autofocus>

                                        @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- First name -->
                                <div class="row mb-3">
                                    <label for="first_name" class="form-label">{{ __('First Name') }}</label>

                                    <div class="">
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $displayUserProfile->first_name }}" required autocomplete="name" autofocus>

                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Last name -->
                                <div class="row mb-3">
                                    <label for="last_name" class="form-label">{{ __('Last Name') }}</label>

                                    <div class="">
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $displayUserProfile->last_name }}" required autocomplete="name" autofocus>

                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Profile picture -->
                                <div class="row mb-3">
                                    <label for="profile_image" class="form-label">{{ __('Profile Picture') }}</label>
                                    @if ($displayUserProfile->profile_image)
                                    <div class="form-image">
                                        <a href="{{ asset($displayUserProfile->profile_image) }}" target="_blank">{{ __('View image') }}</a>
                                    </div>
                                    @endif

                                    <div class="">
                                        <input class="form-control" type="file" id="profile_image" name="profile_image" value="{{ old('profile_image') }}">

                                        @error('profile_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Email & Nickname details -->
                            <div>
                                <div class="row">
                                    <p class="lead">
                                        {{ __('Email details') }}
                                    </p>
                                </div>

                                <!-- Nickname -->
                                <div class="row mb-3">
                                    <label for="nickname" class="form-label">{{ __('Nickname') }}</label>

                                    <div class="">
                                        <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ $displayUserProfile->nickname }}" required autocomplete="name" autofocus>

                                        @error('nickname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email address -->
                                <div class="row mb-3">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>

                                    <div class="">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" disabled name="email" value="{{ $displayUserProfile->email }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password details -->
                            <div>
                                <div class="row">
                                    <p class="lead">
                                        {{ __('Password details') }}
                                    </p>
                                </div>

                                <!-- Password -->
                                <div class="row mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>

                                    <div class="">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password confirmation -->
                                <div class="row mb-3">
                                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                    </div>
                                </div>
                            </div>

                            <div class="card-actions">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
