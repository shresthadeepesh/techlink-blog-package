    <x-blog-input-text
            name="title"
            placeholder="This is a category title"
            :value="$model->title ?? null"
            label="Category Title" />

    <x-blog-input-textarea
            name="description"
            placeholder="This is a category description"
            :value="$model->description ?? null"
            label="Category Description" />

    <x-blog-input-file
        name="image"
        label="Choose file"
    />

    @include('blog::meta._form')

    <x-blog-input-submit />