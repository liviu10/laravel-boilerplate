@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        {{-- @include('components.admin-header', ['title' => 'Users']) --}}

        {{-- @include('components.admin-table', [
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
                'canAdd' => true,
                'canFilter' => true,
                'hasActions' => true,
                'canShow' => true,
                'canEdit' => true,
                'canDelete' => true,
                'canRestore' => true,
            ],
        ]) --}}
    </div>
@endsection
