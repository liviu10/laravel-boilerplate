<select
    aria-label="Default select example"
    class="form-select"
    id="{{ $input['id'] }}"
    name="{{ $input['id'] }}"
>
    @foreach($input['options'] as $key => $value)
        <option value="{{ $value['value'] }}">{{ $value['label'] }}</option>
    @endforeach
</select>
