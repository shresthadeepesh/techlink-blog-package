@csrf
<div class="form-group">
    <label for=""></label>
    <input type="text" name="title" class="form-control @error('title') 'is-invalid' @enderror" value="{{ $post->title ?? '' }}" />
</div>