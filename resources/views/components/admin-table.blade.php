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
                @if ($results['options']['canAdd'])
                    <a
                        class="btn btn-primary"
                        href="{{ route($results['actions']['create']) }}"
                        title="{{ __('Click here to add a new record') }}"
                    >
                        <i class="fa-solid fa-plus"></i>
                        {{ __('Add new') }}
                    </a>
                @endif
                @if ($results['options']['canFilter'])
                    <button
                        class="btn btn-primary"
                        data-bs-target="#filterModal"
                        data-bs-toggle="modal"
                        title="__('Click here to filter & sort the records')"
                        type="button"
                    >
                        <i class="fa-solid fa-filter"></i>
                        {{ __('Filter & sort') }}
                    </button>
                @endif
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
                                @if ($subkey === 'is_active' || $subkey === 'privacy_policy' || $subkey === 'terms_and_conditions' || $subkey === 'data_protection')
                                    <span class="badge text-bg-{{ $value ? 'success' : 'danger' }}">
                                        {{ $value ? __('Yes') : __('No') }}
                                    </span>
                                @elseif (gettype($value) === 'array')
                                    @if (array_key_exists('label', $value))
                                        {{ $value['label'] }}
                                    @elseif (array_key_exists('full_name', $value))
                                        {{ $value['full_name'] }}
                                    @elseif (array_key_exists('name', $value))
                                        {{ $value['name'] }}
                                    @endif
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                            @endforeach
                            @if ($results['options']['hasActions'])
                                <td data-cell="actions">
                                    <div class="btn-group" role="action_group" aria-label="Basic example">
                                        @if ($results['options']['canShow'])
                                            <a
                                                class="btn btn-info"
                                                href="{{ route($results['actions']['show'], $row->id) }}"
                                                title="{{ __('Click here to view more details') }}"
                                            >
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endif
                                        @if ($results['options']['canUpdate'])
                                            <a
                                                class="btn btn-warning"
                                                href="{{ route($results['actions']['edit'], $row->id) }}"
                                                title="{{ __('Click here to edit this record') }}"
                                            >
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        @endif
                                        @if ($results['options']['canDelete'])
                                            <button
                                                class="btn btn-danger"
                                                data-bs-target="#deleteModal{{$key}}"
                                                data-bs-toggle="modal"
                                                title="{{ __('Click here to edit this record') }}"
                                                type="button"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                        @if ($results['options']['canRestore'])
                                            <button
                                                class="btn btn-dark"
                                                data-bs-target="#restoreModal{{$key}}"
                                                data-bs-toggle="modal"
                                                title="__('Click here to restore this record')"
                                                type="button"
                                            >
                                                <i class="fa-solid fa-trash-arrow-up"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>

                        <!-- Delete record modal -->
                        @if ($results['options']['canDelete'])
                            @include('components.admin-table-delete-modal', [
                                'action' => $results['actions']['destroy'],
                                'key' => $key,
                                'record' => $row,
                                'id' => $row->id
                            ])
                        @endif

                        <!-- Restore record modal -->
                        @if ($results['options']['canRestore'])
                            @include('components.admin-table-restore-modal', [
                                'action' => $results['actions']['restore'],
                                'key' => $key,
                                'record' => $row,
                                'id' => $row->id
                            ])
                        @endif
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

    <!-- Filter record modal -->
    @if ($results['options']['canFilter'])
        @include('components.admin-table-filter-modal', [
            'action' => $results['actions']['index'],
            'form' => $results['forms']['inputs']
        ])
    @endif
</div>

<script>
    function redirectToCreatePage(actionUrl) {
        debugger;
        window.location.href = actionUrl;
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
