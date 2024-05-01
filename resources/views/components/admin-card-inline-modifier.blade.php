<div class="row admin admin--component">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-8 col-10 admin__card-inline-modifier">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $results['title'] }}
                </h5>
                <div class="card-text">
                    <div>
                        @foreach ($results['records'] as $key => $record)
                            <span class="badge text-bg-primary">
                                {{ $record['label'] }}
                            </span>
                        @endforeach
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
                        <form id="addNewForm" method="POST" action="{{ route('subjects.store') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="New value"
                                    aria-label="NewValue"
                                    class="form-control not-allowed"
                                    disabled
                                    id="value"
                                    readonly="true"
                                    value=""
                                    placeholder="Value"
                                    type="text"
                                >
                                <label for="value">Value</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="label"
                                    aria-label="Label"
                                    class="form-control"
                                    id="label"
                                    placeholder="Label"
                                    type="text"
                                >
                                <label for="label">Label</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="is_active">
                                    <option selected>{{ __('-- Choose something --') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                    <option value="1">{{ __('Yes') }}</option>
                                </select>
                                <label for="is_active">Is active?</label>
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
                        <form id="editForm" method="POST" action="{{ route('subjects.update', 1) }}">
                            @csrf
                            @method('PUT')
                            {{-- <input type="hidden" name="id" value="{{ $data->id }}"> --}}
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="Edit value"
                                    aria-label="EditValue"
                                    class="form-control not-allowed"
                                    disabled
                                    id="value"
                                    readonly="true"
                                    value=""
                                    placeholder="Value"
                                    type="text"
                                >
                                <label for="value">Value</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="label"
                                    aria-label="Label"
                                    class="form-control"
                                    id="label"
                                    placeholder="Label"
                                    type="text"
                                >
                                <label for="label">Label</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="is_active">
                                    <option selected>{{ __('-- Choose something --') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                    <option value="1">{{ __('Yes') }}</option>
                                </select>
                                <label for="is_active">Is active?</label>
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
