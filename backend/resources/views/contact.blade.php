@extends('layouts.admin')

@section('content')
    <div class="admin contact">
        @include('components.generic.page-title', [
            'title' => __('admin.contact.page_title')
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
                @if (Auth::user()->user_role_type_id !== 5 && count($displayAllRecords['contact']) !== 0)
                @include('components.filter-record', [
                    'filter' => [
                        'button_label' => __('admin.general.filter_button_label'),
                        'action_route' => route('contact.index'),
                        'settings' => [
                            [
                                'id' => 1,
                                'label' => __('admin.general.id_column_label'),
                                'filter_id' => 'id',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 2,
                                'label' => __('admin.contact.full_name_column_label'),
                                'filter_id' => 'full_name',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 3,
                                'label' => __('admin.contact.email_column_label'),
                                'filter_id' => 'email',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 4,
                                'label' => __('admin.contact.phone_number_column_label'),
                                'filter_id' => 'phone',
                                'component_type' => 'input'
                            ],
                            [
                                'id' => 5,
                                'label' => __('admin.contact.contact_subject_column_label'),
                                'component_type' => 'select',
                                'filter_id' => 'contact_subject_id',
                                'options' => $displayAllRecords['contact_subjects']
                            ],
                            [
                                'id' => 6,
                                'label' => __('admin.general.privacy_policy_column_label'),
                                'component_type' => 'select',
                                'filter_id' => 'privacy_policy',
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
                            <th scope="col">{{ __('admin.contact.contact_details_column_label') }}</th>
                            <th scope="col">{{ __('admin.contact.message_column_label') }}</th>
                            <th scope="col">{{ __('admin.general.actions_column_label') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($displayAllRecords['contact'] as $key => $data)
                        <tr>
                            <th scope="row">
                                {{ $data->id }}
                            </th>
                            <td>
                                <span>{{ __('admin.contact.full_name_column_label') }}:</span>
                                {{ $data->full_name }}
                                <br>
                                <span>{{ __('admin.contact.contact_subject_column_label') }}:</span>
                                {{ $data->contact_subject->title }}
                                <br>
                                <span>{{ __('admin.contact.email_column_label') }}:</span>
                                <a href="mailto:{{ $data->email }}">
                                    {{ $data->email }}
                                </a>
                                <br>
                                <span>
                                    {{ __('admin.contact.phone_number_column_label') }}:
                                </span>
                                {{ $data->phone }}
                                <br>
                                <span>
                                    {{ __('admin.general.privacy_policy_column_label') }}:
                                </span>
                                @if ($data->privacy_policy === 1)
                                    {{ __('admin.general.yes_label') }}
                                @else
                                    {{ __('admin.general.no_label') }}
                                @endif
                            </td>
                            <td>
                                @if (strlen($data->message) >= 100)
                                    {{ mb_substr($data->message, 0, 100, 'UTF-8') . '...' }}
                                @else
                                    {{ $data->message }}
                                @endif
                            </td>
                            <td>
                                <div>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRecordModal{{ $key }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form id="delete-record" action="{{ route('contact.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">
                                                {{ __('admin.contact.reply_message_title') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('components.show-record-modal', [
                                                'modal' => [
                                                    'key' => $key,
                                                    'title' => __('admin.contact.show_user_title'),
                                                    'settings' => [
                                                        [
                                                            'id' => 1,
                                                            'label' => __('admin.general.id_column_label'),
                                                            'value' => $data->id,
                                                            'label_id' => 'id'
                                                        ],
                                                        [
                                                            'id' => 2,
                                                            'label' => __('admin.contact.full_name_column_label'),
                                                            'value' => $data->full_name,
                                                            'label_id' => 'full_name'
                                                        ],
                                                        [
                                                            'id' => 3,
                                                            'label' => __('admin.contact.email_column_label'),
                                                            'value' => $data->email,
                                                            'label_id' => 'email'
                                                        ],
                                                        [
                                                            'id' => 4,
                                                            'label' => __('admin.contact.phone_number_column_label'),
                                                            'value' => $data->phone,
                                                            'label_id' => 'phone'
                                                        ],
                                                        [
                                                            'id' => 5,
                                                            'label' => __('admin.contact.message_column_label'),
                                                            'value' => $data->message,
                                                            'label_id' => 'message'
                                                        ],
                                                        [
                                                            'id' => 6,
                                                            'label' => __('admin.general.privacy_policy_column_label'),
                                                            'value' => $data->privacy_policy,
                                                            'label_id' => 'privacy_policy'
                                                        ],
                                                        [
                                                            'id' => 7,
                                                            'label' => __('admin.general.created_at_label'),
                                                            'value' => $data->created_at,
                                                            'label_id' => 'created_at'
                                                        ],
                                                        [
                                                            'id' => 8,
                                                            'label' => __('admin.general.updated_at_label'),
                                                            'value' => $data->updated_at,
                                                            'label_id' => 'updated_at'
                                                        ],
                                                    ]
                                                ]
                                            ])
                                            <hr>
                                            <form method="POST" action="{{ route('contact.reply-to-message') }}">
                                                @csrf

                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <!-- Reply message -->
                                                @include('components.generic.textarea', [
                                                    'input' => [
                                                        'id' => 'message',
                                                        'label' => __('admin.contact.reply_message_label'),
                                                    ]
                                                ])

                                                <div class="modal-actions">
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('admin.contact.reply_button_label') }}
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
                {{ $displayAllRecords['contact']->appends(request()->query())->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
