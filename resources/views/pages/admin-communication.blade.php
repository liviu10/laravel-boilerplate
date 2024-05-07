@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'Communication'])

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
                    'title' => __('Contact messages'),
                    'buttonRoute' => route('messages.index')
                ],
                [
                    'id' => 2,
                    'title' => __('Contact responses'),
                    'buttonRoute' => route('responses.index')
                ],
                [
                    'id' => 3,
                    'title' => __('Newsletter campaigns'),
                    'buttonRoute' => route('campaigns.index')
                ],
                [
                    'id' => 4,
                    'title' => __('Newsletter subscribers'),
                    'buttonRoute' => route('subscribers.index')
                ],
                [
                    'id' => 5,
                    'title' => __('Reviews'),
                    'buttonRoute' => route('reviews.index')
                ],
            ]
        ])
    </div>
@endsection
