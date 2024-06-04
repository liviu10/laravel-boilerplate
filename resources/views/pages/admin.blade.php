@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'Dashboard'])

        <div class="admin__body">
            <div class="row admin admin--component">
                <div class="col-8 admin__card-inline-modifier mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                <div class="mb-3">
                                    {{ __('Adresa eveniment') }}
                                </div>
                                <div class="mb-3">
                                    @if ($data['results'] && count($data['results']['google_maps']) > 0)
                                        <span class="badge text-bg-primary">
                                            {{ $data['results']['google_maps']['address'] }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <button
                                        aria-controls="collapseAddNew"
                                        aria-expanded="false"
                                        class="btn btn-primary"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseAddNew"
                                        title="{{ __('Click here to add a new record') }}"
                                        type="button"
                                        @if ($data['results'] && count($data['results']) === 1)
                                        disabled
                                        @endif
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
                                    <form id="addNewForm" method="POST" action="{{ route('storeGoogleMaps') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input
                                                aria-describedby="Address"
                                                aria-label="Address"
                                                class="form-control"
                                                id="address"
                                                name="address"
                                                placeholder="Address"
                                                type="text"
                                                value=""
                                            >
                                            <label for="address">
                                                {{ __('Adresa google maps') }}
                                            </label>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-secondary" type="button" onclick="collapseForm('collapseAddNew')">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button class="btn btn-success" type="submit">
                                                {{ __('Save') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="collapse card-form-edit" id="collapseEdit">
                                    <hr>
                                    <form id="editForm" method="POST" action="{{ count($data['results']['google_maps']) > 0 ? route('updateGoogleMaps', $data['results']['google_maps']['id']) : '#' }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-floating mb-3">
                                            <input
                                                aria-describedby="Address"
                                                aria-label="Address"
                                                class="form-control"
                                                id="address"
                                                name="address"
                                                placeholder="Address"
                                                type="text"
                                                @if ($data['results'] && count($data['results']) > 0)
                                                value="{{ $data['results']['google_maps']['address'] }}"
                                                @endif
                                            >
                                            <label for="address">
                                                {{ __('Adresa google maps') }}
                                            </label>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-secondary" type="button" onclick="collapseForm('collapseEdit')">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button class="btn btn-warning" type="submit">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-8 admin__card-event-images">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                <div class="mb-3">
                                    {{ __('Poze eveniment') }}
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
