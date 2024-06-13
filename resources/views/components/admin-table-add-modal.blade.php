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
            <form
                id="createForm"
                method="POST"
                action="{{ Route::has($action) ? route($action) : '#' }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-body">
                    @foreach ($form as $input)
                        @if($input['is_create'])
                            @include('components.input-' . $input['type'], ['item' => $input ])
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        type="button"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success">
                        {{ _('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
