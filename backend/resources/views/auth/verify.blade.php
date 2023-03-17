@extends('layouts.guest')

@section('content')
    <div class="auth">
        <div class="card">
            <div class="card-header">
                {{ __('auth.verify_email.title') }}
            </div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('auth.verify_email.message') }}
                    </div>
                @endif

                {{ __('auth.verify_email.information') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.verify_email.button') }}</button>.
                </form>
            </div>
        </div>
    </div>
@endsection
