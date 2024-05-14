@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'Contact messages'])

        {{-- @include('components.admin-card-inline-modifier', [
            'results' => [
                'target_new' => 'collapseAddNewContactSubjects',
                'route_new' => 'subjects.store',
                'target_edit' => 'collapseEditContactSubjects',
                'route_update' => 'subjects.update',
                'title' => __('Contact subjects'),
                'records' => [
                    [
                        'id' => 1,
                        'value' => 'subject-a',
                        'label' => 'Subject A',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'value' => 'subject-b',
                        'label' => 'Subject B',
                        'is_active' => true,
                    ],
                    [
                        'id' => 3,
                        'value' => 'subject-c',
                        'label' => 'Subject C',
                        'is_active' => true,
                    ]
                ]
            ]
        ]) --}}

        <form method="POST" action="{{ route('subjects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="value"
                    name="value"
                    placeholder="Value"
                    type="text"
                    value=""
                >
                <label for="value">{{ __('Value') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="label"
                    name="label"
                    placeholder="Label"
                    type="text"
                    value=""
                >
                <label for="label">{{ __('Label') }}</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="is_active" name="is_active">
                    <option selected>{{ __('-- Choose an option --') }}</option>
                    <option value="0">{{ __('No') }}</option>
                    <option value="1">{{ __('Yes') }}</option>
                </select>
                <label for="is_active">{{ __('Is active?') }}</label>
            </div>
            <div class="form-actions">
                <button class="btn btn-secondary" type="button">
                    {{ __('Cancel') }}
                </button>
                <button class="btn btn-success" type="submit">
                    {{ __('Save') }}
                </button>
            </div>
        </form>

        @include('components.admin-table', [
            'results' => [
                'columns' => [
                    __('ID'), __('Column 0'), __('Column 1'), __('Column 2'),
                ],
                'rows' => [
                    [
                        'id' => 1,
                        'column_0' => 'Mark',
                        'column_1' => 'Otto',
                        'column_2' => '@mdo',
                    ],
                    [
                        'id' => 2,
                        'column_0' => 'John',
                        'column_1' => 'Doe',
                        'column_2' => '@doe',
                    ],
                    [
                        'id' => 3,
                        'column_0' => 'Tom',
                        'column_1' => 'Hanks',
                        'column_2' => '@tom',
                    ]
                ],
                'canAdd' => false,
                'canFilter' => true,
                'hasActions' => true,
                'canShow' => true,
                'canEdit' => true,
                'canDelete' => false,
                'canRestore' => false,
            ],
        ])
    </div>
@endsection
