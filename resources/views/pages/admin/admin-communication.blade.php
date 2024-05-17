@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin.admin-header', [
            'title' => $data['title']
        ])

        @include('components.admin.admin-description', [
            'description' => $data['description']
        ])

        @include('components.admin.admin-title-section', [
            'title' => __('Quick access')
        ])

        @include('components.admin.admin-card-shortcuts', [
            'shortcuts' => $data['shortcuts'][0]
        ])
    </div>
@endsection
