@extends('layouts.auth')

@section('content')
    <div class="auth auth--page">
        <div class="card">
            <div class="card-header">
                {{ __('Login') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            {{ __('Email') }}
                        </label>

                        <div class="">
                            <input
                                id="email"
                                type="email"
                                class="form-control
                                @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                            >

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            {{ __('Password') }}
                        </label>

                        <div class="">
                            <input
                                id="password"
                                type="password"
                                class="form-control
                                @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password"
                            >

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-actions">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
