@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <x-page-header title="{{ $data['title'] }}" />

        <div class="admin__jumbotron">
            <x-page-description>
                {{ $data['description'] }}
            </x-page-description>
        </div>

        <div class="admin__body"></div>

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
                'canAdd' => false,
                'canFilter' => true,
                'hasActions' => true,
                'canShow' => true,
                'canEdit' => true,
                'canDelete' => false,
                'canRestore' => false,
            ],
        ]) --}}
    </div>
@endsection
