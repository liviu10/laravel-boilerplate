@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h1>{{ __('Profile') }}</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ __('Update the profile information') }}
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p class="my-0">{{ $message }}</p>
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update', $displayUserProfile->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" value="{{ $displayUserProfile->id }}">

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

                    <!-- Password -->
                    <div class="row mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>

                        <div class="">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
