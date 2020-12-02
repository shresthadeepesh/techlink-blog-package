<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
            type="{{ $type }}"
            name="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
    />
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>