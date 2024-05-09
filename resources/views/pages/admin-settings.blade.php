@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', [
            'title' => $data['title']
        ])

        @include('components.admin-description', [
            'description' => $data['description']
        ])

        @include('components.admin-title-section', [
            'title' => __('Quick access')
        ])

        @include('components.admin-card-shortcuts', [
            'shortcuts' => $data['shortcuts'][0]
        ])
    </div>
@endsection
