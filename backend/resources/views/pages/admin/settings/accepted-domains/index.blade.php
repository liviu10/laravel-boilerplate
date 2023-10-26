@extends('layouts.admin')

@section('content')

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        @foreach($displayAllRecords['results'] as $key => $value)
        <tr>
            <th scope="row">{{ $value->id }}</th>
            <td>{{ $value->domain }}</td>
            <td>{{ $value->type }}</td>
            <td>{{ $value->is_active }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
