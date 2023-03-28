@extends('layouts.admin')

@section('content')
    <div class="admin users">
        <h1>
            {{ __('users_and_roles.users.page_title') }}
        </h1>

        <div class="menu">
            <div class="table-responsive col-lg-8 col-md-8 col-sm-8">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="users_alert">
                        <p class="my-0">{{ $message }}</p>
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (gettype($displayAllRecords['users']) === 'string')
                    <div class="alert alert-danger" role="alert">
                        {{ $displayAllRecords['users'] }}
                    </div>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('users_and_roles.users.column_id') }}</th>
                            <th scope="col">{{ __('users_and_roles.users.column_full_name') }}</th>
                            <th scope="col">{{ __('users_and_roles.users.column_email_and_nickname') }}</th>
                            <th scope="col">{{ __('users_and_roles.users.column_role') }}</th>
                            <th scope="col">{{ __('users_and_roles.users.column_actions') }}</th>
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
                                <span>{{ __('users_and_roles.users.show_label_email') }}:</span>
                                <a href="mailto:{{ $data->email }}">
                                    {{ $data->email }}
                                </a>
                                <br>
                                <span>
                                    {{ __('users_and_roles.users.show_label_nickname') }}:
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
                                                {{  __('users_and_roles.users.show_user_title') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_id') }}:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_full_name') }}:</span>
                                                {{ $data->full_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_first_name') }}:</span>
                                                {{ $data->first_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_last_name') }}:</span>
                                                {{ $data->last_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_nickname') }}:</span>
                                                {{ $data->nickname }} ({{ __('users_and_roles.users.show_label_role') }}: {{ $data->user_role_type->user_role_name }})
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_email') }}:</span>
                                                <a href="mailto:{{ $data->email }}">
                                                    {{ $data->email }}
                                                </a>
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_email_verified_at') }}:</span>
                                                @if ($data->email_verified_at !== null)
                                                    {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->email_verified_at)->format('d.m.Y H:i a') }}
                                                @else
                                                    —
                                                @endif
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('users_and_roles.users.close_button') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">{{ __('users_and_roles.users.update_user_role_title') }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_id') }}:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_full_name') }}:</span>
                                                {{ $data->full_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_first_name') }}:</span>
                                                {{ $data->first_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_last_name') }}:</span>
                                                {{ $data->last_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_nickname') }}:</span>
                                                {{ $data->nickname }} ({{ __('users_and_roles.users.show_label_role') }}: {{ $data->user_role_type->user_role_name }})
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_email') }}:</span>
                                                <a href="mailto:{{ $data->email }}">
                                                    {{ $data->email }}
                                                </a>
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.users.show_label_email_verified_at') }}:</span>
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
                                                        <label for="user_role_type_id" class="form-label">{{ __('users_and_roles.users.show_label_user_role') }}</label>
                                                        <select id="user_role_type_id" class="form-select" aria-label="Default select example" name="user_role_type_id">
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
                                                            {{ __('users_and_roles.users.update_button') }}
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
                @endif
            </div>
        </div>
    </div>

    <div class="admin user-roles">
        <h1>
            {{ __('users_and_roles.user_roles.page_title') }}
        </h1>

        <div class="menu">
            <div class="table-responsive col-lg-8 col-md-8 col-sm-8">
                @if (gettype($displayAllRecords['user_role_types']) === 'string')
                    <div class="alert alert-danger" role="alert">
                        {{ $displayAllRecords['user_role_types'] }}
                    </div>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('users_and_roles.user_roles.column_id') }}</th>
                            <th scope="col">{{ __('users_and_roles.user_roles.column_name_and_description') }}</th>
                            <th scope="col">{{ __('users_and_roles.user_roles.column_is_active') }}</th>
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
                                    {{ __('users_and_roles.user_roles.show_label_name') }}:
                                </span>
                                {{ $data->user_role_name }}
                                <br>
                                <span>
                                    {{ __('users_and_roles.user_roles.show_label_description') }}:
                                </span>
                                {{ $data->user_role_description }}
                            </td>
                            <td>
                                @if ($data->is_active === 1)
                                    {{ __('users_and_roles.user_roles.show_label_is_active.yes') }}
                                @else
                                    {{ __('users_and_roles.user_roles.show_label_is_active.no') }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
@endsection
