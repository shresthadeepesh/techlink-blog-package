<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select
            class="form-control select-multiple custom-select @error($errorName) is-invalid @enderror"
            name="{{ $name }}"
            {{ $multiple ? 'multiple' : '' }}>
        <option value="">Choose a {{ Str::singular($errorName) }}</option>
        @foreach($options as $value => $key)
            <option
                    value="{{ $value }}"
{{--                    if the mutiple is false then the array is not present--}}
{{--                    else then check inside the array--}}
                    {{ (!$multiple && $selected) ? ($selected === $value ? 'selected' : '') : ($selected && in_array($value, $selected) ? 'selected' : '')   }}
            >{{ $key }}</option>
        @endforeach
    </select>
    @error($errorName)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>