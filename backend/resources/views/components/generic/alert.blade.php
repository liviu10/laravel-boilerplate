<div class="{{ $alertClass }}" role="alert">
    @if ($alertType === 'info')
    <i class="fa-solid fa-circle-info"></i>
    @endif

    @if ($alertType === 'success')
    <i class="fa-solid fa-circle-check"></i>
    @endif

    @if ($alertType === 'warning')
    <i class="fa-solid fa-circle-exclamation"></i>
    @endif

    {{ $alertContent }}
</div>
