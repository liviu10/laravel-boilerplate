@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin.admin-header', ['title' => 'Dashboard'])

        <div class="admin__body">
            <x-admin-stats />

            <x-admin-insights />
        </div>
    </div>
@endsection
