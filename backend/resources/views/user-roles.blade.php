@extends('layouts.admin')

@section('content')
    <div class="admin user-roles">
        <h1>
            {{ __('users_and_roles.user_roles.page_title') }}
        </h1>

        <div class="menu">
            <div class="table-responsive col-lg-8 col-md-8 col-sm-8">
                @if (gettype($displayAllRecords) === 'string')
                    <div class="alert alert-danger" role="alert">
                        {{ $displayAllRecords }}
                    </div>
                @else
                <button id="newRecord" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRecordModal">
                    <i class="fa-sharp fa-solid fa-pencil"></i>
                    Add a new record
                </button>
                <!-- New record modal -->
                <div class="modal fade" id="newRecordModal" tabindex="-1" aria-labelledby="newRecordModal" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="newRecordModalLabel">New User Role</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('user-roles.store') }}">
                                    @csrf

                                    <!-- User role name -->
                                    @include('components.input', [
                                        'input' => [
                                            'label' => __('User role name'),
                                            'id' => 'user_role_name',
                                            'type' => 'text',
                                            'value' => '',
                                            'autocomplete' => 'user_role_name',
                                            'disabled' => false
                                        ]
                                    ])

                                    <!-- User role description -->
                                    @include('components.textarea', [
                                        'input' => [
                                            'id' => 'user_role_description',
                                            'label' => __('users_and_roles.user_roles.show_label_user_role_description')
                                        ]
                                    ])

                                    <!-- User role is active -->
                                    <div class="row my-3">
                                        <div>
                                            <label for="is_active" class="form-label">{{ __('users_and_roles.user_roles.show_label_is_active.title') }}</label>

                                            <div class="">
                                                <select class="form-select" aria-label="Default select example" name="is_active">
                                                    <option value="false">No</option>
                                                    <option value="true">Yes</option>
                                                </select>
                                                @error('is_active')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-actions">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Save') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('users_and_roles.user_roles.column_id') }}</th>
                            <th scope="col">{{ __('users_and_roles.user_roles.column_name_and_description') }}</th>
                            <th scope="col">{{ __('users_and_roles.user_roles.column_is_active') }}</th>
                            <th scope="col">{{ __('users_and_roles.user_roles.column_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($displayAllRecords as $key => $data)
                        <tr>
                            <th scope="row">
                                {{ $data->id }}
                            </th>
                            <td>
                                <span>
                                    {{ __('users_and_roles.user_roles.show_label_user_role_name') }}:
                                </span>
                                {{ $data->user_role_name }}
                                <br>
                                <span>
                                    {{ __('users_and_roles.user_roles.show_label_user_role_description') }}:
                                </span>
                                @if (strlen($data->user_role_description) >= 100)
                                    {{ substr($data->user_role_description, 0, 100) . '...' }}
                                @else
                                    {{ $data->user_role_description }}
                                @endif
                            </td>
                            <td>
                                @if ($data->is_active === 1)
                                    {{ __('users_and_roles.user_roles.show_label_is_active.yes') }}
                                @else
                                    {{ __('users_and_roles.user_roles.show_label_is_active.no') }}
                                @endif
                            </td>
                            <td>
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showRecordModal{{ $key }}">
                                        <i class="fas fa-info"></i>
                                    </button>

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRecordModal{{ $key }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                            <!-- Show record modal -->
                            <div class="modal fade" id="showRecordModal{{ $key }}" tabindex="-1" aria-labelledby="showRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="showRecordModalLabel{{ $key }}">
                                                {{  __('users_and_roles.user_roles.show_user_role_title') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_id') }}:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_user_role_name') }}:</span>
                                                {{ $data->user_role_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_user_role_description') }}:</span>
                                                {{ $data->user_role_description }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_is_active.title') }}:</span>
                                                @if ($data->is_active === 1)
                                                    {{ __('users_and_roles.user_roles.show_label_is_active.yes') }}
                                                @else
                                                    {{ __('users_and_roles.user_roles.show_label_is_active.no') }}
                                                @endif
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_created_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d.m.Y H:i a') }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_updated_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('d.m.Y H:i a') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('users_and_roles.user_roles.close_button') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">{{ __('users_and_roles.user_roles.update_user_role_title') }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_id') }}:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_user_role_name') }}:</span>
                                                {{ $data->user_role_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_user_role_description') }}:</span>
                                                {{ $data->user_role_description }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_is_active.title') }}:</span>
                                                @if ($data->is_active === 1)
                                                    {{ __('users_and_roles.user_roles.show_label_is_active.yes') }}
                                                @else
                                                    {{ __('users_and_roles.user_roles.show_label_is_active.no') }}
                                                @endif
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_created_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d.m.Y H:i a') }}
                                            </p>
                                            <p>
                                                <span>{{ __('users_and_roles.user_roles.show_label_updated_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('d.m.Y H:i a') }}
                                            </p>
                                            <form method="POST" action="{{ route('user-roles.update', $data->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <!-- User role name -->
                                                @include('components.input', [
                                                    'input' => [
                                                        'label' => __('users_and_roles.user_roles.show_label_user_role_name'),
                                                        'id' => 'user_role_name',
                                                        'type' => 'text',
                                                        'value' => $data->user_role_name,
                                                        'autocomplete' => 'user_role_name',
                                                        'disabled' => false
                                                    ]
                                                ])

                                                <!-- User role description -->
                                                @include('components.textarea', [
                                                    'input' => [
                                                        'id' => 'user_role_name',
                                                        'label' => __('users_and_roles.user_roles.show_label_user_role_description')
                                                    ]
                                                ])

                                                <!-- Role name -->
                                                @include('components.select', [
                                                    'input' => [
                                                        'id' => 'user_role_name',
                                                        'label' => __('users_and_roles.user_roles.show_label_is_active.title'),
                                                        'options' => $displayAllRecords
                                                    ]
                                                ])

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
                {{ $displayAllRecords->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
