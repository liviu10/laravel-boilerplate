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
                    @if (array_key_exists('button_label', $shortcut))
                        {{ $shortcut['button_label'] }}
                        @if (array_key_exists('button_icon', $shortcut))
                            <i class="{{ $shortcut['button_icon'] }}"></i>
                        @endif
                    @else
                        {{ __('View') }}
                        <i class="fa-solid fa-arrow-right"></i>
                    @endif
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
