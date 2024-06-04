<div class="row admin admin--component">
    <div class="col-10 admin__card-shortcuts">
        @foreach ($shortcuts as $key => $shortcut)
        <div class="col-4 card">
            <div class="card-header">
                {{ $shortcut['title'] }}
            </div>
            <div class="card-body">
                {{ $shortcut['short_description'] }}
            </div>
            <div class="card-footer">
                <a
                    class="btn btn-primary"
                    onclick="goToResource('{{ $shortcut['url'] }}')"
                    title="{{ __('Click here to navigate to', [ 'buttonLabel' => $shortcut['title'] ]) }}"
                    type="button"
                >
                    {{ __('View') }}
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    function goToResource(resourceUrl) {
        if (resourceUrl && resourceUrl !== '') {
            window.location.href = resourceUrl;
        } else {
            window.location.href = "{{ route('admin.index') }}";
        }
    }
</script>
