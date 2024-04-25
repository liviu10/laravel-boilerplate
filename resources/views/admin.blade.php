@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <div class="admin__header">
            @include('components.admin-header', ['title' => 'Dashboard'])
        </div>

        <div class="admin__body">
            <div class="row admin__card-stats">
                <x-admin-stats />
            </div>

            <div class="row admin__insights">
                <x-admin-insights />
            </div>
        </div>
    </div>
@endsection
