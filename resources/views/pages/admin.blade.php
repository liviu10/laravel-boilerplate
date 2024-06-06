@extends('layouts.admin')

@section('content')
    <div class="admin admin--page">
        @include('components.admin-header', ['title' => 'Dashboard'])

        <div class="admin__body">
            @if (Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p class="my-0">
                        {{ __('Detaliile au fost salvate') }}
                    </p>
                    <button
                        type="button"
                        class="btn btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    />
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p class="my-0">
                        {{ __('Detaliile nu au fost salvate') }}
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </p>
                    <button
                        type="button"
                        class="btn btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    />
                </div>
            @endif

            <div class="row admin admin--component">
                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-8 col-sm-8 col-12 admin__card-inline-modifier mx-auto mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                <div class="mb-3">
                                    {{ __('Eveniment') }}
                                </div>
                                <div class="mb-3">
                                    @if ($data['results'] && count($data['results']['google_maps']) > 0)
                                        <p class="mb-0">
                                            {{ __('Adresa') }}:
                                            <span>
                                                {{ $data['results']['google_maps']['address'] }}
                                            </span>
                                        </p>
                                        <p class="mb-0">
                                            {{ __('Descriere') }}:
                                            <span>
                                                {{ $data['results']['google_maps']['description'] }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    <button
                                        aria-controls="collapseAddNewAddress"
                                        aria-expanded="false"
                                        class="btn btn-primary"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseAddNewAddress"
                                        title="{{ __('Click here to add a new record') }}"
                                        type="button"
                                        @if ($data['results'] && count($data['results']) === 1)
                                        disabled
                                        @endif
                                    >
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <button
                                        aria-controls="collapseEditAddress"
                                        aria-expanded="false"
                                        class="btn btn-warning"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseEditAddress"
                                        title="{{ __('Click here to edit the record') }}"
                                        type="button"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-form">
                                <div class="collapse card-form-new" id="collapseAddNewAddress">
                                    <hr>
                                    <form id="addNewFormAddress" method="POST" action="{{ route('storeGoogleMaps') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input
                                                aria-describedby="Description"
                                                aria-label="Description"
                                                class="form-control"
                                                id="description"
                                                name="description"
                                                placeholder="Description"
                                                type="text"
                                                value=""
                                            >
                                            <label for="description">
                                                {{ __('Descriere eveniment') }}
                                            </label>
                                        </div>
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
                                            <button class="btn btn-secondary" type="button" onclick="collapseForm('collapseAddNewAddress')">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button class="btn btn-success" type="submit">
                                                {{ __('Save') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="collapse card-form-edit" id="collapseEditAddress">
                                    <hr>
                                    <form id="editFormAddress" method="POST" action="{{ count($data['results']['google_maps']) > 0 ? route('updateGoogleMaps', $data['results']['google_maps']['id']) : '#' }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-floating mb-3">
                                            <input
                                                aria-describedby="Description"
                                                aria-label="Description"
                                                class="form-control"
                                                id="description"
                                                name="description"
                                                placeholder="Description"
                                                type="text"
                                                @if ($data['results'] && count($data['results']) > 0)
                                                value="{{ $data['results']['google_maps']['description'] }}"
                                                @endif
                                            >
                                            <label for="description">
                                                {{ __('Descriere eveniment') }}
                                            </label>
                                        </div>
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
                                            <button class="btn btn-secondary" type="button" onclick="collapseForm('collapseEditAddress')">
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
            </div>

            <div class="row admin admin--component">
                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-8 col-sm-8 col-12 admin__card-event-images mx-auto mb-3">
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
