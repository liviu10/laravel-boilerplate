@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <div class="admin__header">
            @include('components.admin-header', ['title' => 'Dashboard'])
        </div>

        <div class="admin__body">
            <div class="row admin__card-stats">
                <x-admin-card-stats />
            </div>

            <div class="row admin__google-combo-chart">
                <x-admin-google-combo-chart />
            </div>
        </div>
    </div>
@endsection
