<div>
    <button
        type="button"
        class="btn btn-primary"
        @if(1 === 0)
        onclick="redirectToCreatePage()"
        @else
        data-bs-toggle="modal"
        data-bs-target="#addNewModal"
        @endif
    >
        <i class="fa-solid fa-plus"></i>
        Add new
    </button>

    <button
        type="button"
        class="btn btn-info"
        data-bs-toggle="modal"
        data-bs-target="#filterModal"
    >
        <i class="fa-solid fa-filter"></i>
        Filter
    </button>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>
                <div>
                    <button
                        type="button"
                        class="btn btn-info"
                        data-bs-toggle="modal"
                        data-bs-target="#showModal"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button
                        type="button"
                        class="btn btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button
                        type="button"
                        class="btn btn-dark"
                        data-bs-toggle="modal"
                        data-bs-target="#restoreModal"
                    >
                        <i class="fa-solid fa-trash-arrow-up"></i>
                    </button>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<!-- Add new record modal -->
<div
    class="modal fade"
    id="addNewModal"
    tabindex="-1"
    aria-labelledby="addNewModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addNewModalLabel">
                    {{ __('Add a new record') }}
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="btn btn-success">
                    {{ _('Save') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Filter record modal -->
<div
    class="modal fade"
    id="filterModal"
    tabindex="-1"
    aria-labelledby="filterModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterModalLabel">
                    {{ __('Filter record') }}
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="btn btn-success">
                    {{ __('Filter') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Show record modal -->
<div
    class="modal fade"
    id="showModal"
    tabindex="-1"
    aria-labelledby="showModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showModalLabel">
                    {{ __('Show record details') }}
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit record modal -->
<div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-labelledby="editModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">
                    {{ __('Edit record') }}
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="btn btn-warning">
                    {{ __('Edit') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete record modal -->
<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="deleteModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">
                    {{ __('Delete record') }}
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete the selected record? The deleted record can be recovered by filtering out the deleted records and clicking on the restore button.') }}
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="btn btn-danger">
                    {{ __('Delete') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Restore record modal -->
<div
    class="modal fade"
    id="restoreModal"
    tabindex="-1"
    aria-labelledby="restoreModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="restoreModalLabel">
                    {{ __('Restore record') }}
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to restore the selected record?') }}
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="btn btn-success">
                    {{ __('Restore') }}
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function redirectToCreatePage() {
        window.location.href = "{{ route('subjects.create') }}";
    }
</script>
