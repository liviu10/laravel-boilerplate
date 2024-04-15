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

                <div class="admin__pie-chart">
                    <div class="card">
                        PIE CHART HERE
                    </div>
                </div>
            </div>

            <div class="col-xxl-7 col-xl-9 col-lg-8 col-12 admin--content">
                <div class="admin__card-stats">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">
                                Communication
                                <i class="fa-solid fa-message"></i>
                            </p>
                            <p class="card-text">
                                123 messages
                                <br>
                                15 responses
                            </p>
                            <p class="card-text">
                                vs. last month 25%
                                <i class="fa-solid fa-arrow-up"></i>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">
                                Management
                                <i class="fa-solid fa-newspaper"></i>
                            </p>
                            <p class="card-text">
                                123 messages
                                <br>
                                15 responses
                            </p>
                            <p class="card-text">
                                vs. last month 25%
                                <i class="fa-solid fa-arrow-up"></i>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">
                                Settings
                                <i class="fa-solid fa-gears"></i>
                            </p>
                            <p class="card-text">
                                123 messages
                                <br>
                                15 responses
                            </p>
                            <p class="card-text">
                                vs. last month 25%
                                <i class="fa-solid fa-arrow-up"></i>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="admin__combo-chart">
                    <div class="admin__combo-chart-filters">
                        <div class="admin__combo-chart-filters-resource">
                            <select class="form-select" id="resource_filter" aria-label="Resource filter">
                                <option value="1">Communication</option>
                                <option value="2">Management</option>
                                <option value="3">Settings</option>
                            </select>
                        </div>
                        <div class="admin__combo-chart-filters-date">
                            <select class="form-select" id="week_filter" aria-label="Week filter">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <select class="form-select" id="month_filter" aria-label="Month filter">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <select class="form-select" id="year_filter" aria-label="Year filter">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>

                    <div class="admin__line-chart">
                        <div class="card">
                            LINE CHART HERE
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
