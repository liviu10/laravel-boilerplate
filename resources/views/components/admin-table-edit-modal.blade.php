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
