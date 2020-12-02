<x-blog-input-text
        name="title"
        placeholder="This is a category title"
        :value="$model->title"
        label="Category Title" />

<x-blog-input-textarea
        name="description"
        placeholder="This is a category description"
        :value="$model->description"
        label="Category Description" />

<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>