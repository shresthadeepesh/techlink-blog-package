<?php


namespace Techlink\Blog\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Techlink\Blog\Tests\TestCase;
use Techlink\Blog\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /**
     * @test
     */
    public function test_it_returns_list_of_posts_with_data()
    {
        Post::factory(50)->create();

        $this->get('/blog/posts')->assertOk()
            ->assertViewIs('blog::posts.index')
            ->assertViewHas('posts');
    }

    /**
     * @test
     */
    public function test_it_returns_a_single_post_with_data()
    {
        $post = Post::factory()->create();

        $this->get("/blog/posts/{$post->id}")->assertOk()
            ->assertViewIs('blog::posts.show')
            ->assertViewHas('post');
    }
}