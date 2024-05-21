<div
    aria-hidden="true"
    aria-labelledby="deleteModalLabel{{ $key }}"
    class="modal fade"
    id="deleteModal{{ $key }}"
    tabindex="-1"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel{{ $key }}">
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
                <hr>
                <ul class="list-group">
                @foreach ($record->toArray() as $key => $item)
                    <li class="list-group-item">
                        <b>
                            {{ ucfirst(str_replace('_', ' ', $key)) }}
                        </b>:
                        @if ($key === 'is_active')
                            <span class="badge text-bg-{{ $value ? 'success' : 'danger' }}">
                                {{ $value ? __('Yes') : __('No') }}
                            </span>
                        @else
                            {{ $item }}
                        @endif
                    </li>
                @endforeach
                </ul>
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
                    id="deleteForm"
                    method="POST"
                    action="{{ route($delete_form['action'], $id) }}"
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
