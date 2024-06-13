<div
    aria-hidden="true"
    aria-labelledby="editModalLabel{{ $key }}"
    class="modal fade"
    id="editModal{{ $key }}"
    tabindex="-1"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel{{ $key }}">
                    {{ __('Edit record') }}
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
                action="{{ Route::has($action) ? route($action, $id) : '#' }}"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
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
                    <hr>
                    @foreach ($form as $input)
                        @if($input['is_filter'])
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
                    <button type="submit" class="btn btn-warning">
                        {{ _('Edit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
