<div class="row admin admin--component">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-8 col-10 admin__card-shortcuts">
        @foreach ($shortcuts as $key => $shortcut)
            <a
                class="btn btn-primary"
                onclick="goToResource('{{ $shortcut['buttonRoute'] }}')"
                title="{{ __('Navigate to', [ 'buttonLabel' => $shortcut['title'] ]) }}"
                type="button"
            >
                {{ $shortcut['title'] }}
            </a>
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
