@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'Dashboard'])

        <div class="admin__body">
            {{-- <div class="card">
                <div class="card-body">
                    <form id="addNewForm" method="POST" action="{{ route('admin.saveGoogleMapsLocation') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input
                                aria-describedby="Address"
                                aria-label="Address"
                                class="form-control"
                                id="google_maps_location"
                                name="google_maps_location"
                                placeholder="Address"
                                type="text"
                            >
                            <label for="google_maps_location">
                                {{ __('Adresa google maps') }}
                            </label>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-success" type="submit">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div> --}}
            <div class="row admin admin--component">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-8 col-10 admin__card-inline-modifier">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                {{-- <div>
                                    @foreach ($results['records'] as $key => $record)
                                        <span class="badge text-bg-primary">
                                            {{ $record['label'] }}
                                        </span>
                                    @endforeach
                                </div> --}}
                                <div>
                                    <button
                                        aria-controls="collapseAddNew"
                                        aria-expanded="false"
                                        class="btn btn-primary"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseAddNew"
                                        title="{{ __('Click here to add a new record') }}"
                                        type="button"
                                    >
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <button
                                        aria-controls="collapseEdit"
                                        aria-expanded="false"
                                        class="btn btn-warning"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseEdit"
                                        title="{{ __('Click here to edit the record') }}"
                                        type="button"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-form">
                                <div class="collapse card-form-new" id="collapseAddNew">
                                    <hr>
                                    <form id="addNewForm" method="POST" action="{{ route('admin.saveGoogleMapsLocation') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input
                                                aria-describedby="Address"
                                                aria-label="Address"
                                                class="form-control"
                                                id="google_maps_location"
                                                name="google_maps_location"
                                                placeholder="Address"
                                                type="text"
                                            >
                                            <label for="google_maps_location">
                                                {{ __('Adresa google maps') }}
                                            </label>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-secondary" type="button" onclick="collapseForm('collapseAddNew')">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button class="btn btn-success" type="button">
                                                {{ __('Save') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="collapse card-form-edit" id="collapseEdit">
                                    <hr>
                                    <form id="editForm" method="POST" action="{{ route('subjects.updateGoogleMapsLocation', 1) }}">
                                        @csrf
                                        @method('PUT')
                                        {{-- <input type="hidden" name="id" value="{{ $data->id }}"> --}}
                                        <div class="form-floating mb-3">
                                            <input
                                                aria-describedby="Address"
                                                aria-label="Address"
                                                class="form-control"
                                                id="google_maps_location"
                                                name="google_maps_location"
                                                placeholder="Address"
                                                type="text"
                                                value=""
                                            >
                                            <label for="google_maps_location">
                                                {{ __('Adresa google maps') }}
                                            </label>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-secondary" type="button" onclick="collapseForm('collapseEdit')">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button class="btn btn-warning" type="button">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                const collapseButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');
                collapseButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const targetCollapse = document.querySelector(button.getAttribute('data-bs-target'));
                        const currentlyExpanded = document.querySelector('.collapse.show');
                        if (currentlyExpanded && currentlyExpanded !== targetCollapse) {
                            currentlyExpanded.classList.remove('show');
                        }
                    });
                });
                function collapseForm(collapseId) {
                    const collapseElement = document.getElementById(collapseId);
                    if (collapseElement) {
                        collapseElement.classList.remove('show');
                    }
                };
            </script>
        </div>
    </div>
@endsection
