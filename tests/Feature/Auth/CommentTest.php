<?php


namespace Techlink\Blog\Tests\Feature\Auth;

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

        //faker act as user
        $user = User::first();
        $this->actingAs($user);
    }

    private function commentData()
    {
        return [
          'description' => 'This is the fakers fake test comment.'
        ];
    }

    /**
     * @test
     */
    public function test_it_returns_auth_comments_index_view_with_data()
    {
        Post::factory(10)->create()->each(function($post) {
            //adding meta
            $meta = Meta::factory()->make();
            $post->meta()->save($meta);
            //adding comment
            $comment = Comment::factory()->make();
            $post->comments()->save($comment);
        });

        $this->get(route('blog::comments.auth.index'))
            ->assertOk()
            ->assertViewIs('blog::comments.auth-index')
            ->assertViewHas('comments');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_delete_an_existing_comment()
    {
        $post = Post::factory()->create();
        $meta = Meta::factory()->make();
        $post->meta()->save($meta);
        $comment = Comment::factory()->make();
        $post->comments()->save($comment);

        $this->delete(route("blog::comments.auth.destroy", ['comment' => $comment->id]))
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Comment has been deleted.');


        $this->assertDatabaseMissing('comments', [
            'id' => 1,
            'description' => $comment->description,
            'commentable_id' => 1,
            'commentable_type' => 'Techlink\\Blog\\Models\\Post'
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_comment()
    {
        //generating a new fake comment
        $post = Post::factory()->create();

        //posting the comment
        $this->post(route('blog::comments.auth.store', [
            'post' => $post->id,
        ]), $this->commentData())
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Comment has been created.');

        //checking the db
        $this->assertDatabaseHas('comments', [
            'id' => 1,
            'description' => 'This is the fakers fake test comment.',
            'commentable_id' => 1,
            'commentable_type' => 'Techlink\\Blog\\Models\\Post'
        ]);
    }

    /**
     * @test
     */
    public function test_it_deletes_the_comments_when_a_post_is_deleted()
    {
        $post = Post::factory()->create();
        $meta = Meta::factory()->make();
        $post->meta()->save($meta);
        $comment = Comment::factory()->make();
        $post->comments()->save($comment);

        //checking the db
        $this->assertDatabaseHas('comments', [
            'id' => 1,
        ]);

        //deleting the post
        $post->delete();

        $this->assertDatabaseMissing('comments', [
           'id' => 1,
        ]);
    }
}