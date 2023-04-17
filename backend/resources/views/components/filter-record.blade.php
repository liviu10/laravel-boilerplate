<div class="menu-filters mb-3">
    <button
        id="filterRecords"
        class="btn btn-primary"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#collapseExample"
        aria-expanded="false"
        aria-controls="collapseExample"
    >
        <i class="fa-solid fa-filter"></i>
        {{ $filter['button_label'] }}
    </button>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form method="GET" action="{{ $filter['action_route'] }}">
                @foreach ($filter['settings'] as $key => $data)
                    @if ($data['component_type'] === 'input')
                        @include('components.generic.input', [
                            'input' => [
                                'label' => $data['label'],
                                'id' => $data['filter_id'],
                                'type' => 'text',
                                'autocomplete' => $data['filter_id']
                            ]
                        ])
                    @elseif ($data['component_type'] === 'select')
                        @include('components.generic.select', [
                            'input' => [
                                'id' => $data['filter_id'],
                                'label' => $data['label'],
                                'options' => $data['options']
                            ]
                        ])
                    @endif
                @endforeach
                <div class="card-actions">
                    <div class="d-flex justify-content-evenly">
                        <a href="{{ $filter['action_route'] }}" class="btn btn-warning">
                            {{ __('admin.general.clear_filter_label') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('admin.general.apply_filter_label') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
