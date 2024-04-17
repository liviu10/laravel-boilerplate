@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <div class="admin__header">
            @include('components.admin-header', ['title' => 'Dashboard'])
        </div>

        <div class="admin__body">
            @include('components.admin-card-stats')
        </div>
    </div>
@endsection
