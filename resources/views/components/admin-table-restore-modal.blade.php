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
                <form
                    id="restoreForm"
                    method="POST"
                    action="{{ route($restore_form['action'], $id) }}"
                    enctype="multipart/form-data"
                >
                    <button type="submit" class="btn btn-danger">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
