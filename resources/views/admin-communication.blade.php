@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <div class="admin__header">
            @include('components.admin-header', ['title' => 'Communication'])
        </div>

        <div class="row">
            <div class="col-10 admin__description">
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
        </div>

        <div class="admin__body">
            <div class="row">
                <div class="col-10 admin__shortcuts">
                    <!-- Contact subjects -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Contact subjects'),
                        'buttonRoute' => route('subjects.index')
                    ])

                    <!-- Contact messages -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Contact messages'),
                        'buttonRoute' => route('messages.index')
                    ])

                    <!-- Contact responses -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Contact responses'),
                        'buttonRoute' => route('responses.index')
                    ])

                    <!-- Newsletter campaigns -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Newsletter campaigns'),
                        'buttonRoute' => route('campaigns.index')
                    ])

                    <!-- Newsletter subscribers -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Newsletter subscribers'),
                        'buttonRoute' => route('subscribers.index')
                    ])

                    <!-- Reviews -->
                    @include('components.admin-card-shortcuts', [
                        'title' => __('Reviews'),
                        'buttonRoute' => route('reviews.index')
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-10 admin__content">
                    @include('components.admin-table')
                </div>
            </div>
        </div>
    </div>
@endsection
