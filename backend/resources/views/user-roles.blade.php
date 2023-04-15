@extends('layouts.admin')

@section('content')
    <div class="admin user-roles">
        @include('components.generic.page-title', [
            'title' => __('users_and_roles.user_roles.page_title')
        ])

        <div class="menu">
            <div class="table-responsive col-lg-8 col-md-8 col-sm-8">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="users_alert">
                    <p class="my-0">{{ $message }}</p>
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (gettype($displayAllRecords) === 'string')
                    <div class="alert alert-danger" role="alert">
                        {{ $displayAllRecords }}
                    </div>
                @else
                @if (Auth::user()->user_role_type_id === 1)
                @include('components.filter-record', [
                    'filter' => [
                        'button_label' => __('Filter table'),
                        'action_route' => route('user-roles.index'),
                        'settings' => [
                            [
                                'id' => 1,
                                'label' => __('users_and_roles.user_roles.column_id'),
                                'filter_id' => 'id',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 2,
                                'label' => __('User role name'),
                                'filter_id' => 'user_role_name',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 3,
                                'label' => __('users_and_roles.user_roles.column_is_active'),
                                'component_type' => 'select',
                                'filter_id' => 'is_active',
                                'options' => [ 'No', 'Yes' ]
                            ]
                        ]
                    ]
                ])
                @if ($searchTerms)
                    {{ $searchMessage }}
                @endif
                @endif
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
                                    @if (Auth::user()->user_role_type_id === 1)
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRecordModal{{ $key }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                            <!-- Show record modal -->
                            <div
                                class="modal fade"
                                id="showRecordModal{{ $key }}"
                                tabindex="-1"
                                aria-labelledby="showRecordModalLabel{{ $key }}"
                                aria-hidden="true"
                                data-bs-backdrop="static"
                            >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="showRecordModalLabel{{ $key }}">
                                                {{ __('users_and_roles.user_roles.show_user_role_title') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('components.show-record-modal', [
                                                'modal' => [
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('users_and_roles.user_roles.show_label_id'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('users_and_roles.user_roles.show_label_user_role_name'),
                                                            'value' => $data->user_role_name,
                                                            'label_id' => 'user_role_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('users_and_roles.user_roles.show_label_user_role_description'),
                                                            'value' => $data->user_role_description,
                                                            'label_id' => 'user_role_description'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('users_and_roles.user_roles.show_label_is_active.title'),
                                                            'value' => $data->is_active,
                                                            'label_id' => 'is_active'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('users_and_roles.user_roles.show_label_created_at'),
                                                            'value' => $data->created_at,
                                                            'label_id' => 'created_at'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('users_and_roles.user_roles.show_label_updated_at'),
                                                            'value' => $data->updated_at,
                                                            'label_id' => 'updated_at'
                                                        ],
                                                    ]
                                                ]
                                            ])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->user_role_type_id === 1)
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">{{ __('users_and_roles.user_roles.update_user_role_title') }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('components.show-record-modal', [
                                                'modal' => [
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('users_and_roles.user_roles.show_label_id'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('users_and_roles.user_roles.show_label_user_role_name'),
                                                            'value' => $data->user_role_name,
                                                            'label_id' => 'user_role_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('users_and_roles.user_roles.show_label_user_role_description'),
                                                            'value' => $data->user_role_description,
                                                            'label_id' => 'user_role_description'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('users_and_roles.user_roles.show_label_is_active.title'),
                                                            'value' => $data->is_active,
                                                            'label_id' => 'is_active'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('users_and_roles.user_roles.show_label_created_at'),
                                                            'value' => $data->created_at,
                                                            'label_id' => 'created_at'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('users_and_roles.user_roles.show_label_updated_at'),
                                                            'value' => $data->updated_at,
                                                            'label_id' => 'updated_at'
                                                        ],
                                                    ]
                                                ]
                                            ])
                                            <hr>
                                            <form method="POST" action="{{ route('user-roles.update', $data->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <!-- User role name -->
                                                @include('components.generic.input', [
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
                                                @include('components.generic.textarea', [
                                                    'input' => [
                                                        'id' => 'user_role_description',
                                                        'label' => __('users_and_roles.user_roles.show_label_user_role_description'),
                                                        'value' => $data->user_role_description,
                                                    ]
                                                ])

                                                <!-- Role name -->
                                                @include('components.generic.select', [
                                                    'input' => [
                                                        'id' => 'is_active',
                                                        'label' => __('users_and_roles.user_roles.show_label_is_active.title'),
                                                        'options' => [ 'No', 'Yes' ]
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
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $displayAllRecords->appends(request()->query())->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
