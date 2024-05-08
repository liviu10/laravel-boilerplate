<div class="row admin admin--component">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-10 col-12 admin__card-inline-modifier">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $results['title'] }}
                </h5>
                <div class="card-text">
                    <div>
                        @foreach ($results['records'] as $key => $record)
                            <span class="badge text-bg-primary" onclick="populateEditForm(
                                '{{ $record['id'] }}',
                                '{{ $record['value'] }}',
                                '{{ $record['label'] }}',
                                {{ $record['is_active'] ? 'true' : 'false' }}
                                )"
                            >
                                {{ $record['label'] }}
                            </span>
                        @endforeach
                    </div>
                    <div>
                        <button
                            aria-controls="{{ $results['target_new'] }}"
                            aria-expanded="false"
                            class="btn btn-primary"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $results['target_new'] }}"
                            title="{{ __('Click here to add a new record') }}"
                            type="button"
                        >
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        <button
                            aria-controls="{{ $results['target_edit'] }}"
                            aria-expanded="false"
                            class="btn btn-warning"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $results['target_edit'] }}"
                            title="{{ __('Click here to edit the record') }}"
                            type="button"
                        >
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                    </div>
                </div>
                <div class="card-form">
                    <div class="collapse card-form-new" id="{{ $results['target_new'] }}">
                        <hr>
                        <form id="addNewForm" method="POST" action="{{ route($results['route_new']) }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="New value"
                                    aria-label="NewValue"
                                    class="form-control not-allowed"
                                    disabled
                                    id="newValue"
                                    readonly="true"
                                    value=""
                                    placeholder="Value"
                                    type="text"
                                >
                                <label for="value">{{ __('Value') }}</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="label"
                                    aria-label="Label"
                                    class="form-control"
                                    id="newLabel"
                                    placeholder="Label"
                                    type="text"
                                >
                                <label for="label">{{ __('Label') }}</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="newIsActive">
                                    <option selected>{{ __('-- Choose an option --') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                    <option value="1">{{ __('Yes') }}</option>
                                </select>
                                <label for="is_active">{{ __('Is active?') }}</label>
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-secondary" type="button" onclick="collapseForm('{{ $results['target_new'] }}')">
                                    {{ __('Cancel') }}
                                </button>
                                <button class="btn btn-success" type="button">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="collapse card-form-edit" id="{{ $results['target_edit'] }}">
                        <hr>
                        <p>
                            {{ __('Please select a record before editing!') }}
                        </p>
                        <form id="editForm" method="POST" action="{{ route($results['route_update'], 1) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="">
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="Edit value"
                                    aria-label="EditValue"
                                    class="form-control not-allowed"
                                    disabled
                                    id="editValue"
                                    readonly="true"
                                    value=""
                                    placeholder="Value"
                                    type="text"
                                >
                                <label for="value">{{ __('Value') }}</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input
                                    aria-describedby="label"
                                    aria-label="Label"
                                    class="form-control"
                                    id="editLabel"
                                    placeholder="Label"
                                    type="text"
                                >
                                <label for="label">{{ __('Label') }}</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="editIsActive">
                                    <option selected>{{ __('-- Choose an option --') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                    <option value="1">{{ __('Yes') }}</option>
                                </select>
                                <label for="is_active">{{ __('Is active?') }}</label>
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-secondary" type="button" onclick="collapseForm('{{ $results['target_edit'] }}')">
                                    {{ __('Cancel') }}
                                </button>
                                <button class="btn btn-warning" id="editButton" disabled type="button">
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
            const form = document.getElementById(collapseId);
            if (form) {
                const inputElements = form.querySelectorAll('input');
                inputElements.forEach(input => {
                    input.value = '';
                });
                const selectElement = form.querySelector('select');
                if (selectElement) {
                    selectElement.selectedIndex = 0;
                }
                const editButton = document.getElementById('editButton');
                editButton.classList.add('edit-button-not-allowed');
                editButton.disabled = true;
            }
        }
    };
    function populateEditForm(id, value, label, isActive) {
        const editForm = document.getElementById('editForm');
        const editValueInput = document.getElementById('editValue');
        const editLabelInput = document.getElementById('editLabel');
        const editIsActive = document.getElementById('editIsActive');
        const hiddenIdInput = editForm.querySelector('input[name="id"]');
        const editButton = document.getElementById('editButton');
        editForm.action = editForm.action.replace(/\/\d+$/, `/${id}`);
        hiddenIdInput.value = id;
        editValueInput.value = value;
        editLabelInput.value = label;
        editIsActive.value = isActive ? "1" : "0";
        editButton.classList.remove('edit-button-not-allowed');
        editButton.disabled = false;

    }
    document.addEventListener('DOMContentLoaded', function () {
        const newLabelInput = document.getElementById('newLabel');
        const newValueInput = document.getElementById('newValue');
        newLabelInput.addEventListener('input', function () {
            let sanitizedValue = newLabelInput.value.replace(/[^a-zA-Z0-9]+/g, '-').toLowerCase()
            newValueInput.value = sanitizedValue;
        });
        const editLabelInput = document.getElementById('editLabel');
        const editValueInput = document.getElementById('editValue');
        editLabelInput.addEventListener('input', function () {
            let sanitizedValue = editLabelInput.value.replace(/[^a-zA-Z0-9]+/g, '-').toLowerCase()
            editValueInput.value = sanitizedValue;
        });
        const editButton = document.getElementById('editButton');
        editButton.classList.add('edit-button-not-allowed');
        editButton.disabled = true;
    });
</script>
