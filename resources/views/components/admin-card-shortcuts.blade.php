<div class="row admin admin--component">
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-10 col-12 admin__card-shortcuts">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="btn-group" role="group" aria-label="Basic example">
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
            </div>
        </div>
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
