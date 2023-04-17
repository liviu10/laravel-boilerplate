@foreach ($modal['settings'] as $key => $data)
<p>
    <span>{{ $data['label'] }}:</span>
    @if ($data['label_id'] === 'is_active' || $data['label_id'] === 'privacy_policy')
        @if ($data['value'] === 1)
            {{ __('admin.general.yes_label') }}
        @else
            {{ __('admin.general.no_label') }}
        @endif
    @elseif (in_array('email', $data) && $data['label_id'] === 'email')
        <a href="mailto:{{ $data['value'] }}">
            {{ $data['value'] }}
        </a>
    @elseif (in_array('phone', $data) && $data['label_id'] === 'phone')
        @if ($data['value'] !== null)
            <a href="tel:{{ $data['value'] }}">{{ $data['value'] }}</a>
        @else
            —
        @endif
    @elseif (in_array('message', $data) && $data['label_id'] === 'message')
        <div style="overflow-y: scroll; height: 200px">
            {{ $data['value'] }}
        </div>
    @elseif (in_array('email_verified_at', $data) && $data['label_id'] === 'email_verified_at')
        @if ($data['value'] !== null)
            {{ DateTime::createFromFormat('Y-m-d H:i:s', $data['value'])->format('d.m.Y H:i a') }}
        @else
            —
        @endif
    @elseif (in_array('created_at', $data) && $data['label_id'] === 'created_at')
        {{ DateTime::createFromFormat('Y-m-d H:i:s', $data['value'])->format('d.m.Y H:i a') }}
    @elseif (in_array('updated_at', $data) && $data['label_id'] === 'updated_at')
        {{ DateTime::createFromFormat('Y-m-d H:i:s', $data['value'])->format('d.m.Y H:i a') }}
    @else
        {{ $data['value'] }}
    @endif
</p>
@endforeach
