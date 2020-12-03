<?php


namespace Techlink\Blog\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Techlink\Blog\Models\Meta;
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

    /**
     * @test
     */
    public function test_it_returns_list_of_posts_with_data()
    {
        $post = Post::factory(50)->create();
        $this->get(route('blog::posts.index'))->assertOk()
            ->assertViewIs('blog::posts.index')
            ->assertViewHas('posts')
            ->assertSeeTextInOrder([$post[0]->title, $post[1]->title, $post[2]->title]);
    }

    /**
     * @test
     */
    public function test_it_returns_a_single_post_with_data()
    {
        $post = Post::factory()->create();
        $meta = Meta::factory()->make();
        $post->meta()->save($meta);

        $this->get($post->path())->assertOk()
            ->assertViewIs('blog::posts.show')
            ->assertViewHas('post')
            ->assertSeeText($post->title)
            ->assertSeeText($post->description);;
    }
}