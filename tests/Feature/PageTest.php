<?php


namespace Techlink\Blog\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Techlink\Blog\Models\Meta;
use Techlink\Blog\Models\Post;
use \Techlink\Blog\Tests\TestCase;
use Techlink\Blog\Tests\User;

class PageTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        //creating the users
        User::factory(10)->create();
    }

    /**
     * @test
     */
    public function test_it_returns_page_view_from_the_db()
    {
        $post = Post::factory()->create(['type' => 'page']);
        $meta = Meta::factory()->make();
        $post->meta()->save($meta);

        $this->get($post->path())->assertOk()
            ->assertViewIs('blog::posts.show')
            ->assertViewHas('post')
            ->assertSeeText($post->title)
            ->assertSeeText($post->description);;
    }

    /**
     * @test
     */
    public function test_it_returns_page_view_from_the_views_directory()
    {
        $this->withoutExceptionHandling();

        $this->get(route('blog::pages.show', ['page' => 'contact']))
            ->assertOk()
            ->assertViewIs('blog::pages.contact')
            ->assertSee('Contact Us');
    }
}