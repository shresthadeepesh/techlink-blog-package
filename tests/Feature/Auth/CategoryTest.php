<?php


namespace Techlink\Blog\Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Techlink\Blog\Models\Meta;
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
            'meta_title' => 'A new post is here.',
            'meta_description' => 'This is the post description',
            'meta_keywords' => "blog, test, cms, package"
        ];
    }

    /**
     * @test
     */
    public function test_it_returns_auth_category_index_view_with_data()
    {
        Category::factory(10)->create()->each(function($category) {
            $meta = Meta::factory()->make();
            $category->meta()->save($meta);
        });

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
        $this->withoutExceptionHandling();

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
    public function test_it_is_able_to_create_a_new_category_including_image()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image('category.jpg');

        $this->post(route('blog::categories.auth.store'), array_merge($this->categoryData(), [
            'image' => $file
        ]))->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been created.');

        $this->assertCount(1, Category::all());

        $this->assertDatabaseHas('images', [
            'id' => 1,
        ]);

        // Assert the file was stored...
//        Storage::disk('images')->assertExists($file->hashName());
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
    public function test_it_is_able_to_update_an_existing_category_including_image()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image('category.jpg');

        $category = Category::factory()->create();

        $this->put(route('blog::categories.auth.update', ['category' => $category->id]), array_merge($this->categoryData(), [
            'image' => $file
        ]))->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been updated.');

        $this->assertCount(1, Category::all());

        $this->assertDatabaseHas('images', [
            'id' => 1,
        ]);

        // Assert the file was stored...
//        Storage::disk('images')->assertExists($file->hashName());
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

    /**
     * @test
     */
    public function test_it_is_able_to_delete_an_existing_category_including_image()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image('category.jpg');

        //creating a new category
        $category = Category::factory()->create();

        //updating the category with image
        $this->put(route('blog::categories.auth.update', ['category' => $category->id]), array_merge($this->categoryData(), [
            'image' => $file
        ]))->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been updated.');

        $this->assertCount(1, Category::all());

        $this->assertDatabaseHas('images', [
            'id' => 1,
        ]);

        //deleting
        $this->delete(route('blog::categories.auth.destroy', ['category' => $category->id]))
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been deleted.');

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
        $this->post(route('blog::categories.auth.store'), $this->categoryData())
            ->assertStatus(302)
            ->assertSessionHas(config('blog.flash_variable'), 'Category has been created.');

        $this->assertCount(1, Category::all());

        $this->assertDatabaseHas('metas', [
            'id' => 1,
            'title' => 'A new post is here.',
            'description' => 'This is the post description',
            'keywords' => "blog, test, cms, package",
            'metaable_id' => 1,
            'metaable_type' => 'Techlink\\Blog\\Models\\Category'
        ]);
    }
}