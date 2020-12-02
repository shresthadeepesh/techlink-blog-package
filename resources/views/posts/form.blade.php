    <x-blog-input-text
        name="title"
        placeholder="This is a post title"
        :value="$post->title"
        label="Post Title" />

    <x-blog-input-textarea
            name="description"
            placeholder="This is a post description"
            :value="$post->description"
            label="Post Description" />

    <x-blog-input-select
            name="categories[]"
            :options="$category"
            :value="$post->categories->modelKeys()"
            label="Select Category"
            multiple="true"
    />

    <x-blog-input-select
            name="status"
            :options="['0' => 'Draft', '1' => 'Publish']"
            :value="$post->status"
            label="Select Status"
    />

    <x-blog-input-select
            name="type"
            :options="['standard' => 'Standard', 'quote' => 'Quote']"
            :value="$post->type"
            label="Select Status"
    />

    <div class="form-group">
        <input type="submit" value="Submit" class="btn btn-primary">
    </div>