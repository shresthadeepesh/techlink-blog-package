<div class="form-group">
    <label class="custom-file-label" for="{{ $name }}">{{ $label }}</label>
    @if($value)
        <img src="{{ asset($value) }}" alt="" class="w-80" />
    @endif
    <input
            class="form-control custom-file-input @error($name) is-invalid @enderror"
            type="file"
            name="{{ $name }}"
            accept="image/png, image/jpg, image/jpeg"
    />
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>