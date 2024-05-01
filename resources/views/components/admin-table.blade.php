<div class="row admin admin--component">
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-10 col-12 admin__table">
        <div class="admin__table-header">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button
                    class="btn btn-primary"
                    data-bs-target="#addNewModal"
                    data-bs-toggle="modal"
                    title="{{ __('Click here to add a new record') }}"
                    type="button"
                >
                    <i class="fa-solid fa-plus"></i>
                    {{ __('Add new') }}
                </button>
                <button
                    class="btn btn-primary"
                    data-bs-target="#filterModal"
                    data-bs-toggle="modal"
                    title="{{ __('Click here to filter the records') }}"
                    type="button"
                >
                    <i class="fa-solid fa-filter"></i>
                    {{ __('Filter') }}
                </button>
            </div>
        </div>

        <div class="admin__table-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            <div>
                                ID
                                <i class="fa-solid fa-sort-up" onclick="ascendSort()"></i>
                                <i class="fa-solid fa-sort-down" onclick="descendSort()"></i>
                            </div>
                        </th>
                        <th scope="col">
                            <div>
                                First
                                <i class="fa-solid fa-sort-up" onclick="ascendSort()"></i>
                                <i class="fa-solid fa-sort-down" onclick="descendSort()"></i>
                            </div>
                        </th>
                        <th scope="col">
                            <div>
                                Last
                                <i class="fa-solid fa-sort-up" onclick="ascendSort()"></i>
                                <i class="fa-solid fa-sort-down" onclick="descendSort()"></i>
                            </div>
                        </th>
                        <th scope="col">
                            <div>
                                Handle
                                <i class="fa-solid fa-sort-up" onclick="ascendSort()"></i>
                                <i class="fa-solid fa-sort-down" onclick="descendSort()"></i>
                            </div>
                        </th>
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
                            <div class="btn-group" role="action_group" aria-label="Basic example">
                                <button
                                    class="btn btn-info"
                                    data-bs-target="#showModal"
                                    data-bs-toggle="modal"
                                    title="{{ __('Click here to view more details') }}"
                                    type="button"
                                >
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button
                                    class="btn btn-warning"
                                    data-bs-target="#editModal"
                                    data-bs-toggle="modal"
                                    title="{{ __('Click here to edit this record') }}"
                                    type="button"
                                >
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button
                                    class="btn btn-danger"
                                    data-bs-target="#deleteModal"
                                    data-bs-toggle="modal"
                                    title="{{ __('Click here to delete this record') }}"
                                    type="button"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button
                                    class="btn btn-dark"
                                    data-bs-target="#restoreModal"
                                    data-bs-toggle="modal"
                                    title="{{ __('Click here to restore this record') }}"
                                    type="button"
                                >
                                    <i class="fa-solid fa-trash-arrow-up"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add new record modal -->
    <div
        aria-hidden="true"
        aria-labelledby="addNewModalLabel"
        class="modal fade"
        id="addNewModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addNewModalLabel">
                        {{ __('Add a new record') }}
                    </h1>
                    <button
                        aria-label="Close"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button"
                    ></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
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
        aria-hidden="true"
        aria-labelledby="filterModalLabel"
        class="modal fade"
        id="filterModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="filterModalLabel">
                        {{ __('Filter record') }}
                    </h1>
                    <button
                        aria-label="Close"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button"
                    ></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
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
        aria-hidden="true"
        aria-labelledby="showModalLabel"
        class="modal fade"
        id="showModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showModalLabel">
                        {{ __('Show record details') }}
                    </h1>
                    <button
                        aria-label="Close"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button"
                    ></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
                    >
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit record modal -->
    <div
        aria-hidden="true"
        aria-labelledby="editModalLabel"
        class="modal fade"
        id="editModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">
                        {{ __('Edit record') }}
                    </h1>
                    <button
                        aria-label="Close"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button"
                    ></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
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
        aria-hidden="true"
        aria-labelledby="deleteModalLabel"
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">
                        {{ __('Delete record') }}
                    </h1>
                    <button
                        aria-label="Close"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button"
                    ></button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete the selected record? The deleted record can be recovered by filtering out the deleted records and clicking on the restore button.') }}
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
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
        aria-hidden="true"
        aria-labelledby="restoreModalLabel"
        class="modal fade"
        id="restoreModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="restoreModalLabel">
                        {{ __('Restore record') }}
                    </h1>
                    <button
                        class="btn-close"
                        aria-label="Close"
                        data-bs-dismiss="modal"
                        type="button"
                    ></button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to restore the selected record?') }}
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
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
</div>
<script>
    function redirectToCreatePage() {
        window.location.href = resourceUrl;
    }
    function ascendSort() {

    }
    function descendSort() {

    }
</script>
