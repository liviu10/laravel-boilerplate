@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-page-title', [ 'title' => 'Communication' ])

        <div class="row admin--body">
            @include('components.admin-menu-buttons', $data = [
                [
                    'id' => 1,
                    'url' => route('subjects.index'),
                    'title' => __('Subjects')
                ],
                [
                    'id' => 2,
                    'url' => route('messages.index'),
                    'title' => __('Messages')
                ],
                [
                    'id' => 3,
                    'url' => route('responses.index'),
                    'title' => __('Responses')
                ],
                [
                    'id' => 4,
                    'url' => route('campaigns.index'),
                    'title' => __('Campaigns')
                ],
                [
                    'id' => 5,
                    'url' => route('campaigns.index'),
                    'title' => __('Subscribers')
                ],
                [
                    'id' => 6,
                    'url' => route('reviews.index'),
                    'title' => __('Reviews')
                ],
            ])
        </div>
    </div>
@endsection
