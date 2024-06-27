@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        <x-page-header title="{{ $data['title'] }}" />

        <div class="admin__jumbotron">
            <x-page-description>
                {{ $data['description'] }}
            </x-page-description>
        </div>

        <div class="admin__body">
            <x-page-card>
                @foreach ($data['results']->toArray()[0] as $key => $item)
                    @if ($key !== 'id')
                        <div class="card-text">
                            {{ ucwords(str_replace('_', ' ', $key)) }}:
                            {{ $item }}
                        </div>
                    @endif
                @endforeach
            </x-page-card>
        </div>
    </div>
@endsection
