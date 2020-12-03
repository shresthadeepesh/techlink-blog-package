<?php


namespace Techlink\Blog\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Techlink\Blog\Models\Meta;
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

    /**
     * @test
     */
    public function test_it_returns_category_show_view_with_data()
    {
        $category = Category::factory()->create();
        $meta = Meta::factory()->make();
        $category->meta()->save($meta);

        $this->get($category->path())
            ->assertOk()
            ->assertViewIs('blog::categories.show')
            ->assertViewHas('category')
            ->assertSeeText($category->title);
    }
}