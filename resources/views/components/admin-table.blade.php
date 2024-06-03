@php
    $tableButtonGroup = [
        [
            'id' => 1,
            'target' => '#addNewModal',
            'title' => __('Click here to add a new record'),
            'icon' => 'fa-solid fa-plus',
            'label' => __('Add new'),
            'is_active' => $results['options']['canAdd'],
        ],
        [
            'id' => 2,
            'target' => '#filterModal',
            'title' => __('Click here to filter & sort the records'),
            'icon' => 'fa-solid fa-filter',
            'label' => __('Filter & sort'),
            'is_active' => $results['options']['canFilter'],
        ]
    ];

    $tableActions = [
        [
            'class' => 'btn btn-info',
            'id' => 1,
            'target' => '#showModal',
            'title' => __('Click here to view more details'),
            'icon' => 'fa-solid fa-eye',
            'is_active' => $results['options']['canShow'],
        ],
        [
            'class' => 'btn btn-warning',
            'id' => 2,
            'target' => '#editModal',
            'title' => __('Click here to edit this record'),
            'icon' => 'fa-solid fa-pencil',
            'is_active' => $results['options']['canUpdate'],
        ],
        [
            'class' => 'btn btn-danger',
            'id' => 3,
            'target' => '#deleteModal',
            'title' => __('Click here to delete this record'),
            'icon' => 'fa-solid fa-trash',
            'is_active' => $results['options']['canDelete'],
        ],
        [
            'class' => 'btn btn-dark',
            'id' => 4,
            'target' => '#restoreModal',
            'title' => __('Click here to restore this record'),
            'icon' => 'fa-solid fa-trash-arrow-up',
            'is_active' => $results['options']['canRestore'],
        ],
    ];
@endphp

<div class="row admin admin--component">
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 admin__table">
        {{-- <div class="admin__table-search-results">
            {{ __('Search results for') }}:
            <button class="btn btn-primary" title="{{ __('Click here to clear all filters') }}" type="button">
                {{ __('Clear filters') }}
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div> --}}

        <div class="admin__table-header">
            <div class="btn-group" role="group" aria-label="Basic example">
                @foreach ($tableButtonGroup as $item)
                    @if ($item['is_active'])
                        <button
                            class="btn btn-primary"
                            data-bs-target="{{ $item['target'] }}"
                            data-bs-toggle="modal"
                            title="{{ $item['title'] }}"
                            type="button"
                        >
                            <i class="{{ $item['icon'] }}"></i>
                            {{ $item['label'] }}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="admin__table-body">
            <table class="table">
                <thead>
                    <tr>
                        @foreach ($results['columns'] as $column)
                            <th scope="col">
                                <div>
                                    {{ $column }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if (array_key_exists('rows', $results) && $results['rows'] && count($results['rows']) > 0)
                    @foreach ($results['rows'] as $key => $row)
                        <tr>
                            @foreach ($row->toArray() as $subkey => $value)
                            <td data-cell="{{ $subkey }}">
                                @if ($subkey === 'is_active')
                                    <span class="badge text-bg-{{ $value ? 'success' : 'danger' }}">
                                        {{ $value ? __('Yes') : __('No') }}
                                    </span>
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                            @endforeach
                            @if ($results['options']['hasActions'])
                                <td data-cell="actions">
                                    <div class="btn-group" role="action_group" aria-label="Basic example">
                                        @foreach ($tableActions as $item)
                                            @if ($item['is_active'])
                                                <button
                                                    class="{{ $item['class'] }}"
                                                    data-bs-target="{{ $item['target'] . '' . $key }}"
                                                    data-bs-toggle="modal"
                                                    title="{{ $item['title'] }}"
                                                    type="button"
                                                >
                                                    <i class="{{ $item['icon'] }}"></i>
                                                </button>

                                                <!-- Show record modal -->
                                                {{-- @if ($results['options']['canShow'])
                                                    @include('components.admin-table-show-modal', [
                                                        'key' => $key,
                                                        'record' => $row
                                                    ])
                                                @endif --}}

                                                <!-- Edit record modal -->
                                                {{-- @if ($results['options']['canUpdate'])
                                                    @include('components.admin-table-edit-modal', [
                                                        'update_form' => $results['forms']['update_form'],
                                                        'key' => $key,
                                                        'record' => $row
                                                    ])
                                                @endif --}}

                                                <!-- Delete record modal -->
                                                {{-- @if ($results['options']['canDelete'])
                                                    @include('components.admin-table-delete-modal', [
                                                        'delete_form' => $results['forms']['delete_form'],
                                                        'key' => $key,
                                                        'record' => $row,
                                                        'id' => $row->id
                                                    ])
                                                @endif --}}

                                                <!-- Restore record modal -->
                                                {{-- @if ($results['options']['canRestore'])
                                                    @include('components.admin-table-restore-modal', [
                                                        'key' => $key,
                                                        'record' => $row,
                                                        'id' => $row->id
                                                    ])
                                                @endif --}}
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="{{ count($results['columns']) + 1 }}">
                                {{ __('There are no data to be displayed! Please try again later!') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if ($results['options']['hasPagination'])
                {{ $results['rows']->appends(request()->query())->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>

    <!-- Add new record modal -->
    {{-- @if ($results['options']['canAdd'])
        @include('components.admin-table-add-modal', [
            'create_form' => $results['forms']['create_form']
        ])
    @endif --}}

    <!-- Filter record modal -->
    {{-- @if ($results['options']['canFilter'])
        @include('components.admin-table-filter-modal', [
            'filter_form' => $results['forms']['filter_form']
        ])
    @endif --}}
</div>

<script>
    function redirectToCreatePage() {
        window.location.href = resourceUrl;
    }
    function transformDataCells() {
        var cells = document.querySelectorAll('[data-cell]');
        cells.forEach(function(cell) {
            var cellContent = cell.getAttribute('data-cell');
            var transformedContent = cellContent.replace(/[_-]/g, ' ').toUpperCase();
            transformedContent = transformedContent.charAt(0).toUpperCase() + transformedContent.slice(1).toLowerCase();
            cell.setAttribute('data-cell', transformedContent);
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        transformDataCells();
    });
</script>
