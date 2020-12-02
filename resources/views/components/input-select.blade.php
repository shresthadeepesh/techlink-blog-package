<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select
            class="form-control @error($errorName) is-invalid @enderror"
            name="{{ $name }}"
            {{ $multiple ? 'multiple' : '' }}>
        @foreach($options as $value => $key)
            <option
                    value="{{ $value }}"
                    {{ ($selected && in_array($value, $selected)) ? 'selected' : '' }}
            >{{ $key }}</option>
        @endforeach
    </select>
    @error($errorName)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>