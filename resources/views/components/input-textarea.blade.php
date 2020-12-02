<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea
            type="{{ $type }}"
            name="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            style="height: 350px;"
            placeholder="{{ $placeholder }}"
    >{{ $value }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>