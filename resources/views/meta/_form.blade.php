    <x-blog-input-text
        name="meta_title"
        placeholder="This is the meta title"
        :value="$model->meta->title ?? null"
        label="Meta Title"
    />

    <x-blog-input-text
            name="meta_keywords"
            placeholder="This is the meta keywords"
            :value="$model->meta->keywords ?? null"
            label="Meta Keywords"
    />

    <x-blog-input-textarea
            name="meta_description"
            placeholder="This is the meta description"
            :value="$model->meta->description ?? null"
            label="Meta Description" />