<div class="card">
    <div class="card-header">
        {{ $cardHeader }}
    </div>
    <div class="card-body">
        <p class="card-text">
            {{ $cardBody }}
        </p>
    </div>
    @if ($displayCardFooter)
    <div class="card-footer">
        @if ($actionButton['display'])
        <div>
            <a href="{{ $actionButton['buttonUrl'] }}" class="{{ $actionButton['buttonClass'] }}" target="_blank">
                {{ $actionButton['buttonLabel'] }}
            </a>
        </div>
        @endif
    </div>
    @endif
</div>
