## Techlink Blog Package

This first blog package developed by me, since cms are almost a necessity for everyone.
 Here is a free open source starter boiler plate which is well tested with various assertions..
 
#### What does it include?
- Contains auth routes for CRUD operations.
- Contains Taxonomies (categories, tags), Posts.
- Contain images, meta details for the taxonomies and posts.

#### File Names
- Config file `blog.php`
- ServiceProvider file `BlogProvider.php`
- A list of components like `Alert, InputText, InputTextarea, InputSelect, InputFile, InputSubmit, PostBlock` and more.
- Traits `BlogUser, HasFactory, Image, Meta, Slug` and more.
- Service file `BlogService.php`


#### Features
- Meta and Images table is automatically deleted.
- Stored images is rename to hash name.
- Both category and post is sync to a table named category_post.
- Input form component like text, textarea, select, submit and more is redesigned for reusability.

The views can be easily customize by running the following command by publishing the view files.
`php artisan vendor:publish --provider="Techlink\Blog\Provider\BlogProvider`

Config file contains various optional config variable which can be modified.
- `flash_variable` used for setting up a flash session variable.
- `auth_model_paginate` used for setting the total rows of record to show in the dashboard.

### Installation and Usability
- Initially publish the vendor files.
- Add the BlogUserTrait into the User model from. `use Techlink\Blog\Traits\BlogUserTrait`
- Run the migrations.
- You are all done. Enjoy!

#### Web Route Structure
- `/blog/posts` for the post index view.
- `/blog/posts/{postId}-{slug}` for the post show  view.
- `/blog/auth/posts` for the auth post index view.
- `/blog/auth/posts/create` for the post create view.
- `/blog/auth/posts/{postId}/edit` for the post edit view.

- `/blog/categories/{categoryId}-{slug}` for the category show  view.
- `/blog/auth/categories` for the auth category index view.
- `/blog/auth/categories/create` for the category create view.
- `/blog/auth/categories/{categoryId}/edit` for the category edit view.

