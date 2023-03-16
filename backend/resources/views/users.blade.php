@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h1>{{ __('Users list') }}</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="col-md-10">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="my-0">{{ $message }}</p>
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                @foreach ($displayAllRecords['users'] as $key => $data)
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
                                        <p>Nickname: {{ $data->nickname }} (user role: {{ $data->user_role_type->user_role_slug }})</p>
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
                                        <p>Id: {{ $data->id }}</p>
                                        <p>Full name: {{ $data->full_name }}</p>
                                        <p>First name: {{ $data->first_name }}</p>
                                        <p>Last name: {{ $data->last_name }}</p>
                                        <p>Nickname: {{ $data->nickname }} (user role: {{ $data->user_role_type->user_role_slug }})</p>
                                        <p>Email: {{ $data->email }}</p>
                                        <p>Email verified at: {{ $data->email_verified_at }}</p>
                                        <form method="POST" action="{{ route('users.update', $data->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="id" value="{{ $data->id }}">

                                            <!-- Full name -->
                                            <div class="row mb-3">
                                                <label for="user_role_type_id" class="form-label">{{ __('Update the user role type') }}</label>

                                                {{ $displayAllRecords['user_role_types'] }}

                                                <div class="">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Choose the user role name</option>
                                                        @foreach ($displayAllRecords['user_role_types'] as $key => $item)
                                                        <option value="{{ $item->id }}">{{ $item->id }} -> {{ $item->user_role_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_role_type_id')
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
