@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'Management'])

        @include('components.admin-description', [
            'description' => '
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '
        ])

        @include('components.admin-title-section', ['title' => __('Quick access')])

        @include('components.admin-card-shortcuts', [
            'shortcuts' => [
                [
                    'id' => 1,
                    'title' => __('Content social'),
                    'buttonRoute' => route('social.index')
                ],
                [
                    'id' => 2,
                    'title' => __('Content'),
                    'buttonRoute' => url('admin/management/contents')
                ],
                [
                    'id' => 3,
                    'title' => __('Tags'),
                    'buttonRoute' => route('tags.index')
                ],
                [
                    'id' => 4,
                    'title' => __('Media'),
                    'buttonRoute' => url('admin/management/media')
                ],
                [
                    'id' => 5,
                    'title' => __('Comments'),
                    'buttonRoute' => url('admin/management/comments')
                ],
                [
                    'id' => 6,
                    'title' => __('Appreciations'),
                    'buttonRoute' => route('appreciations.index')
                ],
            ]
        ])

        @include('components.admin-card-inline-modifier', [
            'results' => [
                'title' => __('Content types'),
                'records' => [
                    [
                        'id' => 1,
                        'label' => 'Page',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'label' => 'Article',
                        'is_active' => true,
                    ]
                ]
            ]
        ])

        @include('components.admin-card-inline-modifier', [
            'results' => [
                'title' => __('Content visibilities'),
                'records' => [
                    [
                        'id' => 1,
                        'label' => 'Published',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'label' => 'Draft',
                        'is_active' => true,
                    ],
                    [
                        'id' => 3,
                        'label' => 'Scheduled',
                        'is_active' => true,
                    ],
                    [
                        'id' => 4,
                        'label' => 'Trashed',
                        'is_active' => true,
                    ]
                ]
            ]
        ])

        @include('components.admin-card-inline-modifier', [
            'results' => [
                'title' => __('Media types'),
                'records' => [
                    [
                        'id' => 1,
                        'label' => 'Images',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'label' => 'Documents',
                        'is_active' => true,
                    ],
                    [
                        'id' => 3,
                        'label' => 'Videos',
                        'is_active' => true,
                    ],
                    [
                        'id' => 4,
                        'label' => 'Audio',
                        'is_active' => true,
                    ],
                    [
                        'id' => 5,
                        'label' => 'Others',
                        'is_active' => true,
                    ]
                ]
            ]
        ])

        @include('components.admin-card-inline-modifier', [
            'results' => [
                'title' => __('Comment types'),
                'records' => [
                    [
                        'id' => 1,
                        'label' => 'Comment',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'label' => 'Reply',
                        'is_active' => true,
                    ]
                ]
            ]
        ])

        @include('components.admin-card-inline-modifier', [
            'results' => [
                'title' => __('Comment statuses'),
                'records' => [
                    [
                        'id' => 1,
                        'label' => 'Pending',
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'label' => 'Approved',
                        'is_active' => true,
                    ],
                    [
                        'id' => 3,
                        'label' => 'Spam',
                        'is_active' => true,
                    ],
                    [
                        'id' => 4,
                        'label' => 'Trashed',
                        'is_active' => true,
                    ]
                ]
            ]
        ])
    </div>
@endsection
