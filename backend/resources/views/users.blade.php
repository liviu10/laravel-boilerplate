@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h1>{{ __('User\'s list') }}</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="col-md-10">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Nickname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($displayAllRecords as $key => $data)
                <tr>
                    <th scope="row">{{ $data->id }}</th>
                    <td>{{ $data->full_name }}</td>
                    <td>{{ $data->nickname }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->user_role_type->user_role_slug }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showRecordModal{{ $key }}">
                            <i class="fas fa-info"></i>
                        </button>
                        <!-- Show record modal -->
                        <div class="modal fade" id="showRecordModal{{ $key }}" tabindex="-1" aria-labelledby="showRecordModalLabel{{ $key }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="showRecordModalLabel{{ $key }}">User details</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Id: {{ $data->id }}</p>
                                        <p>Full name: {{ $data->full_name }}</p>
                                        <p>First name: {{ $data->first_name }}</p>
                                        <p>Last name: {{ $data->last_name }}</p>
                                        <p>Nickname: {{ $data->nickname }} ({{ $data->user_role_type->user_role_slug }})</p>
                                        <p>Email: {{ $data->email }}</p>
                                        <p>Email verified at: {{ $data->email_verified_at }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRecordModal{{ $key }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <!-- Edit record modal -->
                        <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">User details</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('profile.update', $data->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="id" value="{{ $data->id }}">

                                            <!-- Full name -->
                                            <div class="row mb-3">
                                                <label for="full_name" class="form-label">{{ __('Full Name') }}</label>

                                                <div class="">
                                                    <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" disabled name="full_name" value="{{ $data->full_name }}" required autocomplete="name" autofocus>

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
                                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" disabled name="first_name" value="{{ $data->first_name }}" required autocomplete="name" autofocus>

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
                                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" disabled name="last_name" value="{{ $data->last_name }}" required autocomplete="name" autofocus>

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
                                                    <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" disabled name="nickname" value="{{ $data->nickname }}" required autocomplete="name" autofocus>

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
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" disabled name="email" value="{{ $data->email }}" required autocomplete="email">

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
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
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
