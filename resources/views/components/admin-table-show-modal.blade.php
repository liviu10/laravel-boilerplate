<div
    aria-hidden="true"
    aria-labelledby="showModalLabel{{ $key }}"
    class="modal fade"
    id="showModal{{ $key }}"
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
