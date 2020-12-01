<?php


namespace Techlink\Blog\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Techlink\Blog\Tests\TestCase;
use Techlink\Blog\Models\Post;
use Techlink\Blog\Tests\User;

class PostTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    private function actAs()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    private function postData()
    {
        return [
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'type' => 'standard',
            'status' => true
        ];
    }

    /**
     * @test
     */
    public function test_it_returns_list_of_posts_with_data()
    {
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
            ->assertViewIs('blog::posts.create')
            ->assertViewHas('post');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_post()
    {
        $this->actAs();

        $this->post(route('blog::posts.store'), $this->postData())
            ->assertStatus(302)
            ->assertSessionHas('message', 'Post has been created.');

        $this->assertDatabaseHas('posts', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'type' => 'standard',
            'status' => true
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
            ->assertSessionHas('message', 'Post has been deleted.');

        $this->assertDatabaseMissing('posts', [
           'id' => 1,
           'title' => $post->title,
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
            ->assertViewIs('blog::posts.edit')
            ->assertViewHas('post');
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
            ->assertSessionHas('message', 'Post has been updated.');

        $this->assertDatabaseHas('posts', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'type' => 'standard',
            'status' => true
        ]);
    }
}