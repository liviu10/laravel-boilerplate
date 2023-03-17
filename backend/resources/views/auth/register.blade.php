@extends('layouts.guest')

@section('content')
    <div class="auth">
        <div class="card card">
            <div class="card-header">
                {{ __('auth.register.title', [ 'applicationName' => config('app.name') ]) }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full name -->
                    <div class="mb-3">
                        <label for="full_name" class="form-label">{{ __('auth.register.full_name') }}</label>

                        <div class="">
                            <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required autocomplete="name" autofocus>

                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- First name -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">{{ __('auth.register.first_name') }}</label>

                        <div class="">
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus>

                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Last name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">{{ __('auth.register.last_name') }}</label>

                        <div class="">
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>

                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Nickname -->
                    <div class="mb-3">
                        <label for="nickname" class="form-label">{{ __('auth.register.nickname') }}</label>

                        <div class="">
                            <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') }}" required autocomplete="name" autofocus>

                            @error('nickname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('auth.register.email') }}</label>

                        <div class="">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('auth.register.password') }}</label>

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
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('auth.register.confirm_password') }}</label>

                        <div class="">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="card-actions">
                        <button type="submit" class="btn btn-primary">
                            {{ __('auth.register.button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
