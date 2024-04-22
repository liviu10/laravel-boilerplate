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
                <x-admin-insights />
            </div>
        </div>
    </div>
@endsection
