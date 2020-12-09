<?php


namespace Techlink\Blog\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Techlink\Blog\Tests\TestCase;
use Techlink\Blog\Models\Comment;
use Techlink\Blog\Models\Meta;
use Techlink\Blog\Models\Post;
use Techlink\Blog\Tests\User;

class CommentTest extends TestCase
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
    public function test_it_contains_comments_in_the_post()
    {
        $post = Post::factory()->create();
        $meta = Meta::factory()->make();
        $post->meta()->save($meta);
        $comment = Comment::factory()->make();
        $post->comments()->save($comment);


        $this->assertDatabaseHas('comments', [
           'id' => 1,
           'description' => $comment->description,
           'commentable_id' => 1,
           'commentable_type' => 'Techlink\\Blog\\Models\\Post'
        ]);

    }
}