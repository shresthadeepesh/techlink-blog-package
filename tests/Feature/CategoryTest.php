<?php


namespace Techlink\Blog\Tests\Feature;

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
    }

    private function actAs()
    {
        $user = User::factory()->create();
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
    public function test_it_returns_category_index_view_with_data()
    {
        Category::factory(10)->create();

        $this->get(route('blog::categories.index'))
            ->assertOk()
            ->assertViewIs('blog::categories.index')
            ->assertViewHas('categories');
    }

    /**
     * @test
     */
    public function test_it_returns_category_show_view_with_data()
    {
        $category = Category::factory()->create();

        $this->get($category->path())
            ->assertOk()
            ->assertViewIs('blog::categories.show')
            ->assertViewHas('category');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_category()
    {
        $this->actAs();
        $this->post(route('blog::categories.store'), $this->categoryData())
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
        $this->actAs();

        $this->get(route('blog::categories.create'))
            ->assertOk()
            ->assertViewIs('blog::categories.create')
            ->assertViewHas('category');
    }

    /**
     * @test
     */
    public function test_it_returns_category_edit_view()
    {
        $this->actAs();

        $category = Category::factory()->create();

        $this->get(route('blog::categories.edit', ['category' => $category->id]))
            ->assertOk()
            ->assertViewIs('blog::categories.edit')
            ->assertViewHas('category');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_update_an_existing_category()
    {
        $this->actAs();
        $category = Category::factory()->create();
        $this->put(route('blog::categories.update', ['category' => $category->id]), $this->categoryData())
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
        $this->actAs();
        $category = Category::factory()->create();
        $this->delete(route('blog::categories.destroy', ['category' => $category->id]))
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
        $this->actAs();

        $post = collect(Post::factory(2)->create()->modelKeys());
        $category = Category::factory()->create();
        $category->posts()->sync($post);

        $this->delete(route('blog::categories.destroy', ['category' => $category->id]))
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