@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'Contact messages'])

        @include('components.admin-table')
    </div>
@endsection
