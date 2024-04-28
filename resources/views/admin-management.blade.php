@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'management'])

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

        @include('components.admin-card-shortcuts', [
            'shortcuts' => [
                [
                    'id' => 1,
                    'title' => __('Content types'),
                    'buttonRoute' => route('types.index')
                ],
                [
                    'id' => 2,
                    'title' => __('Content visibilities'),
                    'buttonRoute' => route('visibilities.index')
                ],
                [
                    'id' => 3,
                    'title' => __('Content social'),
                    'buttonRoute' => route('social.index')
                ],
                [
                    'id' => 4,
                    'title' => __('Content'),
                    'buttonRoute' => url('admin/management/contents')
                ],
                [
                    'id' => 5,
                    'title' => __('Tags'),
                    'buttonRoute' => route('tags.index')
                ],
                [
                    'id' => 6,
                    'title' => __('Media types'),
                    'buttonRoute' => route('types.index')
                ],
                [
                    'id' => 7,
                    'title' => __('Media'),
                    'buttonRoute' => url('admin/management/media')
                ],
                [
                    'id' => 8,
                    'title' => __('Comment types'),
                    'buttonRoute' => route('types.index')
                ],
                [
                    'id' => 9,
                    'title' => __('Comment statuses'),
                    'buttonRoute' => route('statuses.index')
                ],
                [
                    'id' => 10,
                    'title' => __('Comments'),
                    'buttonRoute' => url('admin/management/comments')
                ],
                [
                    'id' => 11,
                    'title' => __('Appreciations'),
                    'buttonRoute' => route('appreciations.index')
                ],
            ]
        ])
    </div>
@endsection
