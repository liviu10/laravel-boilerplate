@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <x-page-header title="{{ $data['title'] }}" />

        @include('components.input-email')

        <div class="admin__body">
            <x-page-description>
                {{ $data['description'] }}
            </x-page-description>
            {{-- <x-admin-stats /> --}}

            {{-- <x-admin-insights />  --}}
        </div>
    </div>
@endsection
