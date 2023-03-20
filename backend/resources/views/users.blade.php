@extends('layouts.admin')

@section('content')
    <div class="admin users">
        <h1>
            {{ __('All users') }}
        </h1>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="users_alert">
                <p class="my-0">{{ $message }}</p>
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="menu">
            <div class="table-responsive col-lg-8 col-md-8 col-sm-8">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Full name</th>
                            <th scope="col">Email address & Nickname</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($displayAllRecords['users'] as $key => $data)
                        <tr>
                            <th scope="row">
                                {{ $data->id }}
                            </th>
                            <td>
                                {{ $data->full_name }}
                            </td>
                            <td>
                                <span>Email address:</span>
                                <a href="mailto:{{ $data->email }}">
                                    {{ $data->email }}
                                </a>
                                <br>
                                <span>
                                    Nickname:
                                </span>
                                {{ $data->nickname }}
                            </td>
                            <td>
                                {{ $data->user_role_type->user_role_name }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showRecordModal{{ $key }}">
                                    <i class="fas fa-info"></i>
                                </button>

                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRecordModal{{ $key }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <!-- Show record modal -->
                            <div class="modal fade" id="showRecordModal{{ $key }}" tabindex="-1" aria-labelledby="showRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="showRecordModalLabel{{ $key }}">
                                                {{  __('User details') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>Id:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>Full name:</span>
                                                {{ $data->full_name }}
                                            </p>
                                            <p>
                                                <span>First name:</span>
                                                {{ $data->first_name }}
                                            </p>
                                            <p>
                                                <span>Last name:</span>
                                                {{ $data->last_name }}
                                            </p>
                                            <p>
                                                <span>Nickname:</span>
                                                {{ $data->nickname }} (user role: {{ $data->user_role_type->user_role_name }})
                                            </p>
                                            <p>
                                                <span>Email:</span>
                                                {{ $data->email }}
                                            </p>
                                            <p>
                                                <span>Email verified at:</span>
                                                @if ($data->email_verified_at !== null)
                                                    {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->email_verified_at)->format('d.m.Y H:i a') }}
                                                @else
                                                    —
                                                @endif
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">Update user role</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>Id:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>Full name:</span>
                                                {{ $data->full_name }}
                                            </p>
                                            <p>
                                                <span>First name:</span>
                                                {{ $data->first_name }}
                                            </p>
                                            <p>
                                                <span>Last name:</span>
                                                {{ $data->last_name }}
                                            </p>
                                            <p>
                                                <span>Nickname:</span>
                                                {{ $data->nickname }} (user role: {{ $data->user_role_type->user_role_name }})
                                            </p>
                                            <p>
                                                <span>Email:</span>
                                                {{ $data->email }}
                                            </p>
                                            <p>
                                                <span>Email verified at:</span>
                                                @if ($data->email_verified_at !== null)
                                                    {{ $data->email_verified_at }}
                                                @else
                                                    —
                                                @endif
                                            </p>
                                            <form method="POST" action="{{ route('users.update', $data->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <!-- Role name -->
                                                <div class="row my-3">
                                                    <div>
                                                        <select class="form-select" aria-label="Default select example" name="user_role_type_id">
                                                            <option selected>{{ __('Choose the user role type') }}</option>
                                                            @foreach ($displayAllRecords['user_role_types'] as $key => $item)
                                                            <option value="{{ $item->id }}">{{ $item->user_role_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('user_role_type_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="modal-actions">
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="admin user-roles">
        <h1>
            {{ __('User roles') }}
        </h1>

        <div class="menu">
            <div class="table-responsive col-lg-8 col-md-8 col-sm-8">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name & Description</th>
                            <th scope="col">Is active?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($displayAllRecords['user_role_types'] as $key => $data)
                        <tr>
                            <th scope="row">
                                {{ $data->id }}
                            </th>
                            <td>
                                <span>
                                    Name:
                                </span>
                                {{ $data->user_role_name }}
                                <br>
                                <span>
                                    Description:
                                </span>
                                {{ $data->user_role_description }}
                            </td>
                            <td>
                                @if ($data->user_role_is_active === 1)
                                    {{ __('Yes') }}
                                @else
                                    {{ __('No') }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
