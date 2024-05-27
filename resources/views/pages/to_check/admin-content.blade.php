@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        {{-- @include('components.admin-header', ['title' => 'Content']) --}}

        {{-- @include('components.admin-card-inline-modifier', [
            'results' => [
                'target_new' => 'collapseAddNewContentTypes',
                'route_new' => 'types.store',
                'target_edit' => 'collapseEditContentTypes',
                'route_update' => 'types.update',
                'title' => __('Content types'),
                'records' => [
                    [
                        'id' => 1,
                        'value' => 'page',
                        'label' => 'Page',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'value' => 'article',
                        'label' => 'Article',
                        'is_active' => true,
                    ]
                ]
            ]
        ]) --}}

        {{-- @include('components.admin-card-inline-modifier', [
            'results' => [
                'target_new' => 'collapseAddNewContentVisibilities',
                'route_new' => 'visibilities.store',
                'target_edit' => 'collapseEditContentVisibilities',
                'route_update' => 'visibilities.update',
                'title' => __('Content visibilities'),
                'records' => [
                    [
                        'id' => 1,
                        'value' => 'published',
                        'label' => 'Published',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'value' => 'draft',
                        'label' => 'Draft',
                        'is_active' => true,
                    ],
                    [
                        'id' => 3,
                        'value' => 'scheduled',
                        'label' => 'Scheduled',
                        'is_active' => true,
                    ],
                    [
                        'id' => 4,
                        'value' => 'trashed',
                        'label' => 'Trashed',
                        'is_active' => true,
                    ]
                ]
            ]
        ]) --}}

        {{-- @include('components.admin-card-inline-modifier', [
            'results' => [
                'target_new' => 'collapseAddNewCommentTypes',
                'route_new' => 'types.store',
                'target_edit' => 'collapseEditCommentTypes',
                'route_update' => 'types.update',
                'title' => __('Comment types'),
                'records' => [
                    [
                        'id' => 1,
                        'value' => 'comment',
                        'label' => 'Comment',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'value' => 'reply',
                        'label' => 'Reply',
                        'is_active' => true,
                    ]
                ]
            ]
        ]) --}}

        {{-- @include('components.admin-card-inline-modifier', [
            'results' => [
                'target_new' => 'collapseAddNewCommentStatuses',
                'route_new' => 'statuses.store',
                'target_edit' => 'collapseEditCommentStatuses',
                'route_update' => 'statuses.update',
                'title' => __('Comment statuses'),
                'records' => [
                    [
                        'id' => 1,
                        'value' => 'pending',
                        'label' => 'Pending',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'value' => 'approved',
                        'label' => 'Approved',
                        'is_active' => true,
                    ],
                    [
                        'id' => 3,
                        'value' => 'spam',
                        'label' => 'Spam',
                        'is_active' => true,
                    ],
                    [
                        'id' => 4,
                        'value' => 'trashed',
                        'label' => 'Trashed',
                        'is_active' => true,
                    ]
                ]
            ]
        ]) --}}

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
