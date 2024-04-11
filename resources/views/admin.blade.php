@extends('layouts.admin')

@section('content')
    <div class="container">
        @include('components.generic-page-title', [ 'title' => 'Admin dashboard page' ])

        @include('components.admin-card-group-stats')

        @include('components.admin-card-message-chart')

        @include('components.admin-card-newsletter-chart')

        @include('components.admin-card-review-chart')

        @include('components.admin-card-content-chart')

        @include('components.admin-card-storage-chart')
    </div>
@endsection
