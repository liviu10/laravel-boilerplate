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
                        @elseif (gettype($item) === 'array')
                            @if (array_key_exists('label', $item))
                                {{ $item['label'] }}
                            @elseif (array_key_exists('full_name', $item))
                                {{ $item['full_name'] }}
                            @elseif (array_key_exists('name', $item))
                                {{ $item['name'] }}
                            @endif
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
                    action="{{ Route::has($action) ? route($action, $id) : '#' }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
