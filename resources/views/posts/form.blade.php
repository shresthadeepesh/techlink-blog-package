    <x-blog-input-text
        name="title"
        placeholder="This is a post title"
        :value="$model->title ?? null"
        label="Post Title" />

    <x-blog-input-textarea
            name="description"
            placeholder="This is a post description"
            :value="$model->description ?? null"
            label="Post Description" />

    <x-blog-input-select
            name="categories[]"
            :options="$category"
            :value="$model->categories->modelKeys() ?? null"
            label="Select Category"
            multiple="true"
    />

    <x-blog-input-select
            name="status"
            :options="['0' => 'Draft', '1' => 'Publish']"
            :value="$model->status"
            label="Select Status"
    />

    <x-blog-input-select
            name="type"
            :options="['standard' => 'Standard', 'quote' => 'Quote']"
            :value="$model->type"
            label="Select Status"
    />

    <x-blog-input-file
            name="image"
            label="Choose file"
    />

    @include('blog::meta._form')

    <x-blog-input-submit />