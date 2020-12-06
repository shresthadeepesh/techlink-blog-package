<?php


namespace Techlink\Blog\Tests\Unit;

use Illuminate\Http\Request;
use Techlink\Blog\Http\Middleware\SlugMiddleware;
use Techlink\Blog\Tests\TestCase;

class SlugMiddlewareTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_forgets_the_slug_param_in_the_route()
    {
        $request = new Request;

        $request->merge([
            'slug' => 'this-is-the-title'
        ]);

        $middleware = new SlugMiddleware;

        $middleware->handle($request, function ($req) {
           $this->assertEquals('', $req->slug);
        });

    }
}