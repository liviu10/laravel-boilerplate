@extends('layouts.guest')

@section('content')
    <div class="auth">
        <div class="card">
            <div class="card-header">
                {{ __('auth.login.title', [ 'applicationName' => config('app.name') ]) }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('auth.login.email') }}</label>

                        <div class="">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('auth.login.password') }}</label>

                        <div class="">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember me -->
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('auth.login.remember') }}
                        </label>
                    </div>

                    <div class="card-actions">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('auth.login.forget') }}
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            {{ __('auth.login.button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection