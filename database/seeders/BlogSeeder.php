<?php

namespace Techlink\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Techlink\Blog\Models\Category;
use Techlink\Blog\Models\Post;
use Techlink\Blog\Tests\User;

class BlogSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create();
        Category::factory(10)->create();
        Post::factory(10)->create();
    }
}