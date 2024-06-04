<div class="row admin admin--component">
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-10 col-12 admin__card-shortcuts">
        @foreach ($shortcuts as $key => $shortcut)
        <div class="card">
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
                    {{ __('Go to') }} {{ $shortcut['title'] }}
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
            window.location.href = "{{ route('index') }}";
        }
    }
</script>
