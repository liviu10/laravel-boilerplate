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
            <form
                id="filterForm"
                method="GET"
                action="{{ Route::has($action) ? route($action) : '#' }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-body">
                    @foreach ($form as $input)
                        @include('components.input-' . $input['type'], ['item' => $input ])
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
                        {{ _('Filter') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
