<?php


namespace Techlink\Blog\Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Techlink\Blog\Models\Post;
use Techlink\Blog\Tests\TestCase;
use Techlink\Blog\Models\Category;
use Techlink\Blog\Tests\User;

class CategoryTest extends TestCase
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

    private function categoryData()
    {
        return [
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
        ];
    }

    /**
     * @test
     */
    public function test_it_returns_auth_category_index_view_with_data()
    {
        Category::factory(10)->create();
        $this->get(route('blog::categories.auth.index'))
            ->assertOk()
            ->assertViewIs('blog::categories.auth-index')
            ->assertViewHas('categories');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_category()
    {
        $this->post(route('blog::categories.auth.store'), $this->categoryData())
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been created.');

        $this->assertCount(1, Category::all());

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
        ]);
    }

    /**
     * @test
     */
    public function test_it_returns_category_create_view()
    {
        $this->get(route('blog::categories.auth.create'))
            ->assertOk()
            ->assertViewIs('blog::forms.create')
            ->assertViewHas('model');
    }

    /**
     * @test
     */
    public function test_it_returns_category_edit_view()
    {
        $category = Category::factory()->create();
        $this->get(route('blog::categories.auth.edit', ['category' => $category->id]))
            ->assertOk()
            ->assertViewIs('blog::forms.edit')
            ->assertViewHas('model');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_update_an_existing_category()
    {
        $category = Category::factory()->create();
        $this->put(route('blog::categories.auth.update', ['category' => $category->id]), $this->categoryData())
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been updated.');

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_delete_a_category()
    {
        $category = Category::factory()->create();
        $this->delete(route('blog::categories.auth.destroy', ['category' => $category->id]))
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been deleted.');

        $this->assertCount(0, Category::all());

        $this->assertDatabaseMissing('categories', [
            'id' => 1,
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_delete_an_existing_category_among_with_the_synced_data()
    {
        $post = collect(Post::factory(2)->create()->modelKeys());
        $category = Category::factory()->create();
        $category->posts()->sync($post);

        $this->delete(route('blog::categories.auth.destroy', ['category' => $category->id]))
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been deleted.');

        $this->assertCount(0, Category::all());

        $this->assertDatabaseMissing('categories', [
            'id' => 1,
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
}