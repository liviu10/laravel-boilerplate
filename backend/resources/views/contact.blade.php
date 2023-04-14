@extends('layouts.admin')

@section('content')
    <div class="admin contact">
        @include('components.generic.page-title', [
            'title' => __('contact.page_title')
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
                @if (Auth::user()->user_role_type_id !== 5)
                @include('components.filter-record', [
                    'filter' => [
                        'button_label' => __('Filter table'),
                        'action_route' => route('contact.filter'),
                        'settings' => [
                            [
                                'id' => 1,
                                'label' => __('contact.column_id'),
                                'filter_id' => 'id',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 2,
                                'label' => __('Full Name'),
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
                                'label' => __('Phone'),
                                'filter_id' => 'phone',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 5,
                                'label' => __('Privacy Policy'),
                                'component_type' => 'select',
                                'filter_id' => 'privacy_policy',
                                'options' => [ 'No', 'Yes' ]
                            ]
                        ]
                    ]
                ])
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('contact.column_id') }}</th>
                            <th scope="col">{{ __('contact.column_contact_details') }}</th>
                            <th scope="col">{{ __('contact.column_message') }}</th>
                            <th scope="col">{{ __('contact.column_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($displayAllRecords['contact'] as $key => $data)
                        <tr>
                            <th scope="row">
                                {{ $data->id }}
                            </th>
                            <td>
                                <span>{{ __('contact.show_label_full_name') }}:</span>
                                {{ $data->full_name }}
                                <br>
                                <span>{{ __('contact.show_label_email') }}:</span>
                                <a href="mailto:{{ $data->email }}">
                                    {{ $data->email }}
                                </a>
                                <br>
                                <span>
                                    {{ __('contact.show_label_phone_number') }}:
                                </span>
                                {{ $data->phone }}
                                <br>
                                <span>
                                    {{ __('contact.show_label_privacy_policy.title') }}:
                                </span>
                                @if ($data->privacy_policy === 1)
                                    {{ __('contact.show_label_privacy_policy.yes') }}
                                @else
                                    {{ __('contact.show_label_privacy_policy.no') }}
                                @endif
                            </td>
                            <td>
                                @if (strlen($data->message) >= 100)
                                    {{ substr($data->message, 0, 100) . '...' }}
                                @else
                                    {{ $data->message }}
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
                                                    'key' => $key,
                                                    'title' => __('contact.show_user_title'),
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('contact.show_label_id'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('contact.show_label_full_name'),
                                                            'value' => $data->full_name,
                                                            'label_id' => 'full_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('contact.show_label_email'),
                                                            'value' => $data->email,
                                                            'label_id' => 'email'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('contact.show_label_phone_number'),
                                                            'value' => $data->phone,
                                                            'label_id' => 'phone'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('contact.show_label_message'),
                                                            'value' => $data->message,
                                                            'label_id' => 'message'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('contact.show_label_created_at'),
                                                            'value' => $data->created_at,
                                                            'label_id' => 'created_at'
                                                        ],
                                                        [
                                                            'id' => 7,
                                                            'label' => __('contact.show_label_updated_at'),
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
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">{{ __('contact.update_user_role_title') }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('components.show-record-modal', [
                                                'modal' => [
                                                    'key' => $key,
                                                    'title' => __('contact.show_user_title'),
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('contact.show_label_id'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('contact.show_label_full_name'),
                                                            'value' => $data->full_name,
                                                            'label_id' => 'full_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('contact.show_label_email'),
                                                            'value' => $data->email,
                                                            'label_id' => 'email'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('contact.show_label_phone_number'),
                                                            'value' => $data->phone,
                                                            'label_id' => 'phone'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('contact.show_label_message'),
                                                            'value' => $data->message,
                                                            'label_id' => 'message'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('contact.show_label_created_at'),
                                                            'value' => $data->created_at,
                                                            'label_id' => 'created_at'
                                                        ],
                                                        [
                                                            'id' => 7,
                                                            'label' => __('contact.show_label_updated_at'),
                                                            'value' => $data->updated_at,
                                                            'label_id' => 'updated_at'
                                                        ],
                                                    ]
                                                ]
                                            ])
                                            <hr>
                                            <form method="POST" action="{{ route('contact.update', $data->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <!-- Reply message -->
                                                @include('components.generic.textarea', [
                                                    'input' => [
                                                        'id' => 'message',
                                                        'label' => __('Message'),
                                                    ]
                                                ])

                                                <div class="modal-actions">
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('contact.update_button') }}
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
                {{ $displayAllRecords['contact']->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
