<div class="row {{ isset($input['class']) && $input['class'] ? $input['class'] : 'my-3' }}">
    <label for="{{ $input['id'] }}" class="form-label">
        {{ $input['label'] }}
    </label>

    @if (isset($input['value']) && $input['value'] && $input['type'] === 'file')
    <div class="form-image">
        <a href="{{ asset($input['value']) }}" target="_blank">
            {{ $input['view_image_label'] }}
        </a>
    </div>
    @endif

    <div class="">
        <input
            id="{{ $input['id'] }}"
            type="{{ $input['type'] }}"
            class="form-control
            @if($input['id'] !== 'password_confirmation') @error($input['id']) is-invalid @enderror @endif"
            name="{{ $input['id'] }}"
            @if($input['id'] !== 'password' && $input['id'] !== 'password_confirmation') value="{{ isset($input['value']) ? $input['value'] : '' }}" @endif
            {{ isset($input['required']) && $input['required'] ? 'required' : '' }}
            @if($input['id'] !== 'password' && $input['id'] !== 'password_confirmation') autocomplete="{{ $input['autocomplete'] }}" @endif
            autofocus
            {{ isset($input['disabled']) && $input['disabled'] ? 'disabled' : '' }}
        >

        @if($input['id'] !== 'password_confirmation')
            @error($input['id'])
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        @endif
    </div>
</div>
