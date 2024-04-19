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

{{--            <div class="row admin__google-combo-chart">--}}
{{--                @include('components.admin-google-combo-chart', [--}}
{{--                    'chartId' => 'contact_chart',--}}
{{--                    'chartTitle' => 'Contact messages'--}}
{{--                ])--}}
{{--            </div>--}}

{{--            <div class="row admin__google-combo-chart">--}}
{{--                @include('components.admin-google-combo-chart', [--}}
{{--                    'chartId' => 'newsletter_chart',--}}
{{--                    'chartTitle' => 'Newsletter'--}}
{{--                ])--}}
{{--            </div>--}}

{{--            <div class="row admin__google-line-chart">--}}
{{--                @include('components.admin-google-line-chart', [--}}
{{--                    'chartId' => 'review_chart',--}}
{{--                    'chartTitle' => 'Reviews'--}}
{{--                ])--}}
{{--            </div>--}}

{{--            <div class="row admin__google-line-chart">--}}
{{--                @include('components.admin-google-line-chart', [--}}
{{--                    'chartId' => 'content_article_chart',--}}
{{--                    'chartTitle' => 'Articles'--}}
{{--                ])--}}
{{--            </div>--}}

            <div class="row admin__insights">
                <div class="col-xxl-8 col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 admin__insights-content">
                    <p>
                        <button
                            class="btn btn-outline-primary"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseCommunication"
                            aria-expanded="false"
                            aria-controls="collapseCommunication"
                            onclick="toggleCollapse('collapseCommunication')"
                        >
                            Communication
                        </button>
                        <button
                            class="btn btn-outline-primary"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseManagement"
                            aria-expanded="false"
                            aria-controls="collapseManagement"
                            onclick="toggleCollapse('collapseManagement')"
                        >
                            Management
                        </button>
                    </p>
                    <div class="collapse" id="collapseCommunication">
                        <div class="card">
                            <h5 class="card-title">
                                Communication stats
                            </h5>
                            <div class="card-body">
                                Some placeholder content for the collapse component.
                                This panel is hidden by default but revealed when the user activates
                                the relevant trigger.
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="collapseManagement">
                        <div class="card">
                            <h5 class="card-title">
                                Management stats
                            </h5>
                            <div class="card-body">
                                Some placeholder content for the collapse component.
                                This panel is hidden by default but revealed when the user activates
                                the relevant trigger.
                            </div>
                        </div>
                    </div>
                    <script>
                        function toggleCollapse(targetId) {
                            // Get the target element
                            var target = document.getElementById(targetId);

                            // Get all buttons
                            var buttons = document.querySelectorAll('[data-bs-toggle="collapse"]');

                            // Loop through buttons and set aria-expanded to false
                            buttons.forEach(function(button) {
                                button.setAttribute('aria-expanded', 'false');
                            });

                            // Set aria-expanded to true for the clicked button
                            var clickedButton = document.querySelector('[data-bs-target="#' + targetId + '"]');
                            clickedButton.setAttribute('aria-expanded', 'true');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
