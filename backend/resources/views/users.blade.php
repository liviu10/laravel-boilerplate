@extends('layouts.admin')

@section('content')
    <div class="admin users">
        @include('components.generic.page-title', [
            'title' => __('admin.users.page_title')
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
                @if (Auth::user()->user_role_type_id !== 5 && count($displayAllRecords['users']) !== 0)
                @include('components.filter-record', [
                    'filter' => [
                        'button_label' => __('admin.general.filter_button_label'),
                        'action_route' => route('users.index'),
                        'settings' => [
                            [
                                'id' => 1,
                                'label' => __('admin.general.id_column_label'),
                                'filter_id' => 'id',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 2,
                                'label' => __('admin.users.full_name_column_label'),
                                'filter_id' => 'full_name',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 3,
                                'label' => __('admin.users.email_column_label'),
                                'filter_id' => 'email',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 4,
                                'label' => __('admin.users.nickname_column_label'),
                                'filter_id' => 'nickname',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 5,
                                'label' => __('admin.users.column_role'),
                                'component_type' => 'select',
                                'filter_id' => 'user_role_type_id',
                                'options' => $displayAllRecords['user_role_types']
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
                            <th scope="col">{{ __('admin.general.id_column_label') }}</th>
                            <th scope="col">{{ __('admin.users.full_name_column_label') }}</th>
                            <th scope="col">{{ __('admin.users.email_and_nickname_column_label') }}</th>
                            <th scope="col">{{ __('admin.users.role_column_label') }}</th>
                            <th scope="col">{{ __('admin.general.actions_column_label') }}</th>
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
                                <span>{{ __('admin.users.email_column_label') }}:</span>
                                <a href="mailto:{{ $data->email }}">
                                    {{ $data->email }}
                                </a>
                                <br>
                                <span>
                                    {{ __('admin.users.nickname_column_label') }}:
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
                                                {{ __('admin.general.modal_show_details_title') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('components.show-record-modal', [
                                                'modal' => [
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('admin.general.id_column_label'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('admin.users.full_name_column_label'),
                                                            'value' => $data->full_name,
                                                            'label_id' => 'full_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('admin.users.first_name_column_label'),
                                                            'value' => $data->first_name,
                                                            'label_id' => 'first_name'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('admin.users.last_name_column_label'),
                                                            'value' => $data->last_name,
                                                            'label_id' => 'last_name'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('admin.users.nickname_column_label'),
                                                            'value' => $data->nickname . ' (' . __('admin.users.user_role_label') . ': ' . $data->user_role_type->user_role_name . ')',
                                                            'label_id' => 'nickname'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('admin.users.email_column_label'),
                                                            'value' => $data->email,
                                                            'label_id' => 'email'
                                                        ],
                                                        [
                                                            'id' => 7,
                                                            'label' => __('admin.users.email_verified_at_column_label'),
                                                            'value' => $data->email_verified_at,
                                                            'label_id' => 'email_verified_at'
                                                        ],
                                                    ]
                                                ]
                                            ])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                                {{ __('admin.general.close_button_label') }}
                                            </button>
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
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">
                                                {{ __('admin.general.modal_update_details_title') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('components.show-record-modal', [
                                                'modal' => [
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('admin.general.id_column_label'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('admin.users.full_name_column_label'),
                                                            'value' => $data->full_name,
                                                            'label_id' => 'full_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('admin.users.first_name_column_label'),
                                                            'value' => $data->first_name,
                                                            'label_id' => 'first_name'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('admin.users.last_name_column_label'),
                                                            'value' => $data->last_name,
                                                            'label_id' => 'last_name'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('admin.users.nickname_column_label'),
                                                            'value' => $data->nickname . ' (' . __('admin.users.user_role_label') . ': ' . $data->user_role_type->user_role_name . ')',
                                                            'label_id' => 'nickname'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('admin.users.email_column_label'),
                                                            'value' => $data->email,
                                                            'label_id' => 'email'
                                                        ],
                                                        [
                                                            'id' => 7,
                                                            'label' => __('admin.users.email_verified_at_column_label'),
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
                                                        'label' => __('admin.users.choose_user_role_type_label'),
                                                        'options' => $displayAllRecords['user_role_types']
                                                    ]
                                                ])

                                                <div class="modal-actions">
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('admin.general.update_button_label') }}
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
                {{ $displayAllRecords['users']->appends(request()->query())->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
