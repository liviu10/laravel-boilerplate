@extends('layouts.guest')

@section('content')
    <div class="auth">
        <div class="card">
            <div class="card-header">
                {{ __('auth.confirm_password.title') }}
            </div>

            <div class="card-body">
                {{ __('auth.confirm_password.message') }}

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('auth.confirm_password.password') }}</label>

                        <div class="">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Password confirmation -->
                    <div class="mb-0 card-actions">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('auth.confirm_password.forgot') }}
                            </a>
                        @endif

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('auth.confirm_password.button') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
