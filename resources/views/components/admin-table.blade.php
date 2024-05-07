@php
    $tableButtonGroup = [
        [
            'id' => 1,
            'target' => '#addNewModal',
            'title' => __('Click here to add a new record'),
            'icon' => 'fa-solid fa-plus',
            'label' => __('Add new'),
            'is_active' => $results['canAdd'],
        ],
        [
            'id' => 2,
            'target' => '#filterModal',
            'title' => __('Click here to filter & sort the records'),
            'icon' => 'fa-solid fa-filter',
            'label' => __('Filter & sort'),
            'is_active' => $results['canFilter'],
        ]
    ];

    $tableActions = [
        [
            'class' => 'btn btn-info',
            'id' => 1,
            'target' => '#showModal',
            'title' => __('Click here to view more details'),
            'icon' => 'fa-solid fa-eye',
            'is_active' => $results['canShow'],
        ],
        [
            'class' => 'btn btn-warning',
            'id' => 2,
            'target' => '#editModal',
            'title' => __('Click here to edit this record'),
            'icon' => 'fa-solid fa-pencil',
            'is_active' => $results['canEdit'],
        ],
        [
            'class' => 'btn btn-danger',
            'id' => 3,
            'target' => '#deleteModal',
            'title' => __('Click here to delete this record'),
            'icon' => 'fa-solid fa-trash',
            'is_active' => $results['canDelete'],
        ],
        [
            'class' => 'btn btn-dark',
            'id' => 4,
            'target' => '#restoreModal',
            'title' => __('Click here to restore this record'),
            'icon' => 'fa-solid fa-trash-arrow-up',
            'is_active' => $results['canRestore'],
        ],
    ];
@endphp

<div class="row admin admin--component">
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 admin__table">
        <div class="admin__table-search-results">
            {{ __('Search results for') }}:
            <button class="btn btn-primary" title="{{ __('Click here to clear all filters') }}" type="button">
                {{ __('Clear filters') }}
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

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
                        @if ($results['hasActions'])
                            <th scope="col">
                                <div>
                                    {{ __('Actions') }}
                                </div>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (array_key_exists('rows', $results) && $results['rows'] && count($results['rows']) > 0)
                    @foreach ($results['rows'] as $row)
                        <tr>
                            @foreach ($row as $key => $value)
                                <td data-cell={{ $key }}>{{ $value }}</td>
                            @endforeach
                            @if ($results['hasActions'])
                                <td data-cell="actions">
                                    <div class="btn-group" role="action_group" aria-label="Basic example">
                                        @foreach ($tableActions as $item)
                                            @if ($item['is_active'])
                                                <button
                                                    class="{{ $item['class'] }}"
                                                    data-bs-target="{{ $item['target'] }}"
                                                    data-bs-toggle="modal"
                                                    title="{{ $item['title'] }}"
                                                    type="button"
                                                >
                                                    <i class="{{ $item['icon'] }}"></i>
                                                </button>
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
        </div>
    </div>

    <!-- Add new record modal -->
    @if ($results['canAdd'])
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
                        <button type="button" class="btn btn-success">
                            {{ _('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter record modal -->
    @if ($results['canFilter'])
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
                        <button type="button" class="btn btn-success">
                            {{ __('Filter') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Show record modal -->
    @if ($results['canShow'])
        <div
            aria-hidden="true"
            aria-labelledby="showModalLabel"
            class="modal fade"
            id="showModal"
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
    @endif

    <!-- Edit record modal -->
    @if ($results['canEdit'])
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
    @endif

    <!-- Delete record modal -->
    @if ($results['canDelete'])
        <div
            aria-hidden="true"
            aria-labelledby="deleteModalLabel"
            class="modal fade"
            id="deleteModal"
            tabindex="-1"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">
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
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            type="button"
                        >
                            {{ __('Cancel') }}
                        </button>
                        <button type="button" class="btn btn-danger">
                            {{ __('Delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Restore record modal -->
    @if ($results['canRestore'])
        <div
            aria-hidden="true"
            aria-labelledby="restoreModalLabel"
            class="modal fade"
            id="restoreModal"
            tabindex="-1"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="restoreModalLabel">
                            {{ __('Restore record') }}
                        </h1>
                        <button
                            class="btn-close"
                            aria-label="Close"
                            data-bs-dismiss="modal"
                            type="button"
                        ></button>
                    </div>
                    <div class="modal-body">
                        {{ __('Are you sure you want to restore the selected record?') }}
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            type="button"
                        >
                            {{ __('Cancel') }}
                        </button>
                        <button type="button" class="btn btn-success">
                            {{ __('Restore') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
