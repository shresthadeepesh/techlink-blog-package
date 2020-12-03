<?php

namespace Techlink\Blog\Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Techlink\Blog\Models\Category;
use Techlink\Blog\Tests\TestCase;
use Techlink\Blog\Models\Post;
use Techlink\Blog\Tests\User;

class PostTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        //creating the users
        User::factory(10)->create();

        //fake user acting
        $user = User::first();
        $this->actingAs($user);
    }

    private function postData()
    {
        $category = collect(Category::factory(2)->create()->modelKeys());

        return [
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'type' => 'standard',
            'status' => true,
            'categories' => [$category[0], $category[1]],
            'meta_title' => 'A new post is here.',
            'meta_description' => 'This is the post description',
            'meta_keywords' => "blog, test, cms, package"
        ];
    }

    /**
     * @test
     */
    public function test_it_returns_post_auth_index_with_data()
    {
        Post::factory(50)->create();
        $this->get(route('blog::posts.auth.index'))->assertOk()
            ->assertViewIs('blog::posts.auth-index')
            ->assertViewHas('posts');
    }

    /**
     * @test
     */
    public function test_it_returns_post_create_view()
    {
        $this->get(route('blog::posts.auth.create'))
            ->assertOk()
            ->assertViewIs('blog::forms.create')
            ->assertViewHas('model');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_post()
    {
        $this->post(route('blog::posts.auth.store'), $this->postData())
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been created.');

        $this->assertDatabaseHas('posts', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'type' => 'standard',
            'status' => true
        ]);

        //checking whether the category are synced or not
        $this->assertDatabaseHas('category_post', [
            [
                [
                    'category_id' => 1,
                    'post_id' => 1,
                ],
                [
                    'category_id' => 2,
                    'post_id' => 1,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_post_including_image()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image('category.jpg');

        $this->post(route('blog::posts.auth.store'), array_merge($this->postData(), [
            'image' => $file
        ]))->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been created.');

        $this->assertCount(1, Post::all());

        $this->assertDatabaseHas('images', [
            'id' => 1,
        ]);

        // Assert the file was stored...
//        Storage::disk('images')->assertExists($file->hashName());
    }

    /**
     * @test
     */
    public function test_it_is_able_to_delete_an_existing_post()
    {
        $post = Post::factory()->create();

        $this->delete(route('blog::posts.auth.destroy', ['post' => $post->id]))
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been deleted.');

        $this->assertDatabaseMissing('posts', [
            'id' => 1,
            'title' => $post->title,
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_delete_an_existing_post_among_with_the_synced_data()
    {
        $post = Post::factory()->create();
        $category = collect(Category::factory(2)->create()->modelKeys());
        $post->categories()->sync($category);

        $this->delete(route('blog::posts.auth.destroy', ['post' => $post->id]))
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been deleted.');

        $this->assertDatabaseMissing('posts', [
            'id' => 1,
            'title' => $post->title,
        ]);

        //checking whether the category are synced or not
        $this->assertDatabaseMissing('category_post', [
            [
                [
                    'category_id' => 1,
                    'post_id' => 1,
                ],
                [
                    'category_id' => 1,
                    'post_id' => 1,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function test_it_returns_post_edit_view()
    {
        $post = Post::factory()->create();

        $this->get(route('blog::posts.auth.edit', ['post' => $post->id]))
            ->assertOk()
            ->assertViewIs('blog::forms.edit')
            ->assertViewHas('model');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_update_an_existing_post()
    {
        $post = Post::factory()->create();

        $this->put(route('blog::posts.auth.update', ['post' => $post->id]), $this->postData())
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been updated.');

        $this->assertDatabaseHas('posts', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'type' => 'standard',
            'status' => true
        ]);

        //checking whether the category are synced or not
        $this->assertDatabaseHas('category_post', [
            [
                [
                    'category_id' => 1,
                    'post_id' => 1,
                ],
                [
                    'category_id' => 2,
                    'post_id' => 1,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_update_an_existing_post_including_image()
    {
        $this->withoutExceptionHandling();

        Storage::fake('images');

        $file = UploadedFile::fake()->image('category.jpg');

        //creating a new category
        $post = Post::factory()->create();

        //updating the category with image
        $this->put(route('blog::posts.auth.update', ['post' => $post->id]), array_merge($this->postData(), [
            'image' => $file
        ]))->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been updated.');

        $this->assertCount(1, Post::all());

        $this->assertDatabaseHas('images', [
            'id' => 1,
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_delete_an_existing_post_including_image()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image('category.jpg');

        //creating a new category
        $post = Post::factory()->create();

        //updating the category with image
        $this->put(route('blog::posts.auth.update', ['post' => $post->id]), array_merge($this->postData(), [
            'image' => $file
        ]))->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been updated.');

        $this->assertCount(1, Post::all());

        $this->assertDatabaseHas('images', [
            'id' => 1,
        ]);

        //deleting
        $this->delete(route('blog::posts.auth.destroy', ['post' => $post->id]))
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been deleted.');

        $this->assertDatabaseMissing('images', [
            'id' => 1,
        ]);

        // Assert the file was stored...
        Storage::disk('images')->assertMissing($file->hashName());
    }

    /**
     * @test
     */
    public function test_it_contains_category_meta_info_in_the_db_when_creating()
    {
        $this->post(route('blog::posts.auth.store'), $this->postData())
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Post has been created.');

        $this->assertCount(1, Post::all());

        $this->assertDatabaseHas('metas', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'keywords' => "blog, test, cms, package",
            'metaable_id' => 1,
            'metaable_type' => 'Techlink\\Blog\\Models\\Post'
        ]);
    }
}