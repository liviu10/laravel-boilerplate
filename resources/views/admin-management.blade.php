@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <div class="admin__header">
            @include('components.admin-header', ['title' => 'Management'])
        </div>

        <div class="admin__description">
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
        </div>

        <div class="admin__body">
            <div class="row">
                <div class="col-10 admin__shortcuts">
                    <!-- Content types -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Content types'),
                        'buttonRoute' => route('types.index')
                    ])

                    <!-- Content visibilities -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Content visibilities'),
                        'buttonRoute' => route('visibilities.index')
                    ])

                    <!-- Content social -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Content social'),
                        'buttonRoute' => route('social.index')
                    ])

                    <!-- Content -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Content'),
                        'buttonRoute' => url('admin/management/contents')
                    ])

                    <!-- Tags -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Tags'),
                        'buttonRoute' => route('tags.index')
                    ])

                    <!-- Media types -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Media types'),
                        'buttonRoute' => route('types.index')
                    ])

                    <!-- Media -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Media'),
                        'buttonRoute' => url('admin/management/media')
                    ])

                    <!-- Comment types -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Comment types'),
                        'buttonRoute' => route('types.index')
                    ])

                    <!-- Comment statuses -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Comment statuses'),
                        'buttonRoute' => route('statuses.index')
                    ])

                    <!-- Comments -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Comments'),
                        'buttonRoute' => url('admin/management/comments')
                    ])

                    <!-- Appreciations -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Appreciations'),
                        'buttonRoute' => route('appreciations.index')
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
