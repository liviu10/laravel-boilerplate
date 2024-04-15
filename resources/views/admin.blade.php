@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-page-title', [ 'title' => 'Dashboard' ])

        <div class="row admin--body">
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-12 admin--sidebar">
                @include('components.admin-welcome-card', [ 'currentAuthUser' => Auth::user()->full_name ])

                @include('components.admin-menu-buttons', $data = [
                    [
                        'id' => 1,
                        'url' => route('communication.index'),
                        'title' => __('Communication')
                    ],
                    [
                        'id' => 2,
                        'url' => route('management.index'),
                        'title' => __('Management')
                    ],
                    [
                        'id' => 3,
                        'url' => route('settings.index'),
                        'title' => __('Settings')
                    ],
                ])

                @include('components.admin-pie-chart')
            </div>

            <div class="col-xxl-7 col-xl-9 col-lg-8 col-12 admin--content">
                @include('components.admin-card-stats')

                <div class="admin__combo-chart">
                    @include('components.admin-combo-chart-filters')

                    @include('components.admin-line-chart')
                </div>
            </div>
        </div>
    </div>
@endsection
