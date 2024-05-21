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
                <h1 class="modal-title fs-5" id="showModalLabel{{ $key }}">
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
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>
