<div class="custom-file">
    <input
            class="form-control custom-file-input @error($name) is-invalid @enderror"
            type="file"
            name="{{ $name }}"
            accept="image/png, image/jpg, image/jpeg" />
    <label class="custom-file-label" for="{{ $name }}">{{ $label }}</label>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>