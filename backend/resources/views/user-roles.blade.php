@extends('layouts.admin')

@section('content')
    <div class="admin user-roles">
        @include('components.generic.page-title', [
            'title' => __('admin.user_roles.page_title')
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
                @if (Auth::user()->user_role_type_id === 1 && count($displayAllRecords) !== 0)
                @include('components.filter-record', [
                    'filter' => [
                        'button_label' => __('admin.general.filter_button_label'),
                        'action_route' => route('user-roles.index'),
                        'settings' => [
                            [
                                'id' => 1,
                                'label' => __('admin.general.id_column_label'),
                                'filter_id' => 'id',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 2,
                                'label' => __('admin.user_roles.user_role_name_column_label'),
                                'filter_id' => 'user_role_name',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 3,
                                'label' => __('admin.general.is_active_column_label'),
                                'component_type' => 'select',
                                'filter_id' => 'is_active',
                                'options' => [ __('admin.general.no_label'), __('admin.general.yes_label') ]
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
                            <th scope="col">{{ __('admin.user_roles.name_and_description_column_label') }}</th>
                            <th scope="col">{{ __('admin.general.is_active_column_label') }}</th>
                            <th scope="col">{{ __('admin.general.actions_column_label') }}</th>
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
                                    {{ __('admin.user_roles.user_role_name_column_label') }}:
                                </span>
                                {{ $data->user_role_name }}
                                <br>
                                <span>
                                    {{ __('admin.user_roles.user_role_description_column_label') }}:
                                </span>
                                @if (strlen($data->user_role_description) >= 100)
                                    {{ substr($data->user_role_description, 0, 100) . '...' }}
                                @else
                                    {{ $data->user_role_description }}
                                @endif
                            </td>
                            <td>
                                @if ($data->is_active === 1)
                                    {{ __('admin.general.yes_label') }}
                                @else
                                    {{ __('admin.general.no_label') }}
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
                                                            'label' => __('admin.user_roles.user_role_name_column_label'),
                                                            'value' => $data->user_role_name,
                                                            'label_id' => 'user_role_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('admin.user_roles.user_role_description_column_label'),
                                                            'value' => $data->user_role_description,
                                                            'label_id' => 'user_role_description'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('admin.general.is_active_column_label'),
                                                            'value' => $data->is_active,
                                                            'label_id' => 'is_active'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('admin.general.created_at_label'),
                                                            'value' => $data->created_at,
                                                            'label_id' => 'created_at'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('admin.general.updated_at_label'),
                                                            'value' => $data->updated_at,
                                                            'label_id' => 'updated_at'
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
                            @if (Auth::user()->user_role_type_id === 1)
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
                                                            'label' => __('admin.user_roles.user_role_name_column_label'),
                                                            'value' => $data->user_role_name,
                                                            'label_id' => 'user_role_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('admin.user_roles.user_role_description_column_label'),
                                                            'value' => $data->user_role_description,
                                                            'label_id' => 'user_role_description'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('admin.general.is_active_column_label'),
                                                            'value' => $data->is_active,
                                                            'label_id' => 'is_active'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('admin.general.created_at_label'),
                                                            'value' => $data->created_at,
                                                            'label_id' => 'created_at'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('admin.general.updated_at_label'),
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
                                                        'label' => __('admin.user_roles.user_role_name_column_label'),
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
                                                        'label' => __('admin.user_roles.user_role_description_column_label'),
                                                        'value' => $data->user_role_description,
                                                    ]
                                                ])

                                                <!-- Role name -->
                                                @include('components.generic.select', [
                                                    'input' => [
                                                        'id' => 'is_active',
                                                        'label' => __('admin.general.is_active_column_label'),
                                                        'options' => [ __('admin.general.no_label'), __('admin.general.yes_label') ]
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
                {{ $displayAllRecords->appends(request()->query())->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
