@extends('layouts.admin')

@section('content')
    <div class="admin users">
        @include('components.generic.page-title', [
            'title' => __('users_and_roles.users.page_title')
        ])

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
                @if (Auth::user()->user_role_type_id !== 5)
                @include('components.filter-record', [
                    'filter' => [
                        'button_label' => __('Filter table'),
                        'action_route' => route('users.filter'),
                        'settings' => [
                            [
                                'id' => 1,
                                'label' => __('users_and_roles.users.column_id'),
                                'filter_id' => 'id',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 2,
                                'label' => __('users_and_roles.users.column_full_name'),
                                'filter_id' => 'full_name',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 3,
                                'label' => __('Email'),
                                'filter_id' => 'email',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 4,
                                'label' => __('Nickname'),
                                'filter_id' => 'nickname',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 5,
                                'label' => __('users_and_roles.users.column_role'),
                                'component_type' => 'select',
                                'filter_id' => 'user_role_type_id',
                                'options' => $displayAllRecords['user_role_types']
                            ]
                        ]
                    ]
                ])
                @endif
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
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showRecordModal{{ $key }}">
                                        <i class="fas fa-info"></i>
                                    </button>

                                    @if (Auth::user()->user_role_type_id === 1 || Auth::user()->user_role_type_id === 2)
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
                                                            'label' => __('users_and_roles.users.show_label_id'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('users_and_roles.users.show_label_full_name'),
                                                            'value' => $data->full_name,
                                                            'label_id' => 'full_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('users_and_roles.users.show_label_first_name'),
                                                            'value' => $data->first_name,
                                                            'label_id' => 'first_name'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('users_and_roles.users.show_label_last_name'),
                                                            'value' => $data->last_name,
                                                            'label_id' => 'last_name'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('users_and_roles.users.show_label_nickname'),
                                                            'value' => $data->nickname . ' (' . __('users_and_roles.users.show_label_role') . ': ' . $data->user_role_type->user_role_name . ')',
                                                            'label_id' => 'nickname'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('users_and_roles.users.show_label_email'),
                                                            'value' => $data->email,
                                                            'label_id' => 'email'
                                                        ],
                                                        [
                                                            'id' => 7,
                                                            'label' => __('users_and_roles.users.show_label_email_verified_at'),
                                                            'value' => $data->email_verified_at,
                                                            'label_id' => 'email_verified_at'
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
                            @if (Auth::user()->user_role_type_id === 1 || Auth::user()->user_role_type_id === 2)
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">{{ __('users_and_roles.users.update_user_role_title') }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('components.show-record-modal', [
                                                'modal' => [
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('users_and_roles.users.show_label_id'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('users_and_roles.users.show_label_full_name'),
                                                            'value' => $data->full_name,
                                                            'label_id' => 'full_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('users_and_roles.users.show_label_first_name'),
                                                            'value' => $data->first_name,
                                                            'label_id' => 'first_name'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('users_and_roles.users.show_label_last_name'),
                                                            'value' => $data->last_name,
                                                            'label_id' => 'last_name'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('users_and_roles.users.show_label_nickname'),
                                                            'value' => $data->nickname . ' (' . __('users_and_roles.users.show_label_role') . ': ' . $data->user_role_type->user_role_name . ')',
                                                            'label_id' => 'nickname'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('users_and_roles.users.show_label_email'),
                                                            'value' => $data->email,
                                                            'label_id' => 'email'
                                                        ],
                                                        [
                                                            'id' => 7,
                                                            'label' => __('users_and_roles.users.show_label_email_verified_at'),
                                                            'value' => $data->email_verified_at,
                                                            'label_id' => 'email_verified_at'
                                                        ],
                                                    ]
                                                ]
                                            ])
                                            <hr>
                                            <form method="POST" action="{{ route('users.update', $data->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <!-- Role name -->
                                                @include('components.generic.select', [
                                                    'input' => [
                                                        'id' => 'user_role_type_id',
                                                        'label' => __('users_and_roles.users.show_label_user_role'),
                                                        'options' => $displayAllRecords['user_role_types']
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
                {{ $displayAllRecords['users']->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
