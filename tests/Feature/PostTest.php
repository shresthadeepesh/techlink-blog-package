<?php


namespace Techlink\Blog\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    }

    private function actAs()
    {
        $user = User::factory()->create();
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
        ];
    }

    /**
     * @test
     */
    public function test_it_returns_list_of_posts_with_data()
    {
        $this->withoutExceptionHandling();

        Post::factory(50)->create();

        $this->get(route('blog::posts.index'))->assertOk()
            ->assertViewIs('blog::posts.index')
            ->assertViewHas('posts');
    }

    /**
     * @test
     */
    public function test_it_returns_a_single_post_with_data()
    {
        $post = Post::factory()->create();

        $this->get($post->path())->assertOk()
            ->assertViewIs('blog::posts.show')
            ->assertViewHas('post');
    }

    /**
     * @test
     */
    public function test_it_returns_post_create_view()
    {
        $this->actAs();

        $this->get(route('blog::posts.create'))
            ->assertOk()
            ->assertViewIs('blog::forms.create')
            ->assertViewHas('model');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_post()
    {
        $this->withoutExceptionHandling();

        $this->actAs();

        $this->post(route('blog::posts.store'), $this->postData())
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
    public function test_it_is_able_to_delete_an_existing_post()
    {
        $this->actAs();

        $post = Post::factory()->create();

        $this->delete(route('blog::posts.destroy', ['post' => $post->id]))
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
        $this->actAs();

        $post = Post::factory()->create();
        $category = collect(Category::factory(2)->create()->modelKeys());
        $post->categories()->sync($category);

        $this->delete(route('blog::posts.destroy', ['post' => $post->id]))
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
        $this->actAs();

        $post = Post::factory()->create();

        $this->get(route('blog::posts.edit', ['post' => $post->id]))
            ->assertOk()
            ->assertViewIs('blog::forms.edit')
            ->assertViewHas('model');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_update_an_existing_post()
    {
        $this->actAs();

        $post = Post::factory()->create();

        $this->put(route('blog::posts.update', ['post' => $post->id]), $this->postData())
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
}